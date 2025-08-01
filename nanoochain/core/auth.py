"""
Authentication and authorization utilities for NanooChain.

This module implements a minimal user authentication system with
password hashing, Time‑Based One‑Time Passwords (TOTP) for two‑factor
authentication and JSON Web Token (JWT) creation and verification.

Users are stored in a SQLite database with their password hash,
TOTP secret and assigned role (e.g. ``user`` or ``admin``).  Tokens
are signed using a secret key from the configuration and include an
expiration time.
"""

import os
import sqlite3
import hashlib
import hmac
import base64
import json
import time
import struct
from functools import wraps
from typing import Tuple, Optional, Dict, Any

from flask import request, jsonify

from .config import AUTH_DB_PATH, SECRET_KEY

# Ensure data directory exists
os.makedirs(os.path.dirname(AUTH_DB_PATH), exist_ok=True)

# Global SQLite connection for auth database
_conn = sqlite3.connect(AUTH_DB_PATH, check_same_thread=False)


def _init_db():
    cur = _conn.cursor()
    cur.execute(
        """
        CREATE TABLE IF NOT EXISTS users (
            username TEXT PRIMARY KEY,
            password_hash TEXT NOT NULL,
            totp_secret TEXT NOT NULL,
            role TEXT NOT NULL
        )
        """
    )
    _conn.commit()


_init_db()


# ---------------------------------------------------------------------------
# TOTP helper functions
# ---------------------------------------------------------------------------

def generate_totp_secret() -> str:
    """Generate a new TOTP secret encoded in base32."""
    random_bytes = os.urandom(10)
    return base64.b32encode(random_bytes).decode('utf-8')


def _totp_now(secret: str, interval: int = 30, digits: int = 6) -> str:
    """Compute the current TOTP code for a given secret."""
    key = base64.b32decode(secret, True)
    counter = int(time.time() // interval)
    msg = struct.pack('>Q', counter)
    digest = hmac.new(key, msg, hashlib.sha1).digest()
    ob = digest[19] & 0x0F
    code = ((digest[ob] & 0x7f) << 24 | (digest[ob + 1] & 0xff) << 16 | (digest[ob + 2] & 0xff) << 8 | (digest[ob + 3] & 0xff)) % (10 ** digits)
    return str(code).zfill(digits)


def verify_totp(secret: str, code: str, window: int = 1) -> bool:
    """Verify a TOTP code within a time window.

    Args:
        secret: The base32 encoded TOTP secret.
        code: The 6‑digit code provided by the user.
        window: How many time steps in the past and future to allow.

    Returns:
        True if the code is valid, False otherwise.
    """
    try:
        int(code)
    except ValueError:
        return False
    for offset in range(-window, window + 1):
        counter = int(time.time() // 30) + offset
        key = base64.b32decode(secret, True)
        msg = struct.pack('>Q', counter)
        digest = hmac.new(key, msg, hashlib.sha1).digest()
        ob = digest[19] & 0x0F
        calc = ((digest[ob] & 0x7f) << 24 | (digest[ob + 1] & 0xff) << 16 | (digest[ob + 2] & 0xff) << 8 | (digest[ob + 3] & 0xff)) % 1000000
        if str(calc).zfill(6) == code:
            return True
    return False


# ---------------------------------------------------------------------------
# Password hashing
# ---------------------------------------------------------------------------

def hash_password(password: str, salt: str) -> str:
    return hashlib.sha256((salt + password).encode()).hexdigest()


def create_user(username: str, password: str, role: str = 'user') -> Tuple[bool, Optional[str]]:
    """Create a new user in the auth database.

    Returns a tuple ``(success, secret)``.  On success, ``secret``
    contains the TOTP secret to be shared with the user.
    """
    cur = _conn.cursor()
    # Check if user exists
    cur.execute("SELECT username FROM users WHERE username = ?", (username,))
    if cur.fetchone():
        return False, None
    totp_secret = generate_totp_secret()
    salt = username  # simple salt; could be random per user
    pwd_hash = hash_password(password, salt)
    cur.execute(
        "INSERT INTO users (username, password_hash, totp_secret, role) VALUES (?, ?, ?, ?)",
        (username, pwd_hash, totp_secret, role),
    )
    _conn.commit()
    return True, totp_secret


def verify_user(username: str, password: str) -> Optional[Dict[str, Any]]:
    """Verify username/password and return user record if valid."""
    cur = _conn.cursor()
    cur.execute("SELECT username, password_hash, totp_secret, role FROM users WHERE username = ?", (username,))
    row = cur.fetchone()
    if not row:
        return None
    stored_hash = row[1]
    salt = username
    if hash_password(password, salt) != stored_hash:
        return None
    return {'username': row[0], 'totp_secret': row[2], 'role': row[3]}


# ---------------------------------------------------------------------------
# JWT encoding and decoding
# ---------------------------------------------------------------------------

def _base64url_encode(data: bytes) -> str:
    return base64.urlsafe_b64encode(data).decode('utf-8').rstrip('=')


def _base64url_decode(data: str) -> bytes:
    padding = '=' * (4 - (len(data) % 4)) if (len(data) % 4) else ''
    return base64.urlsafe_b64decode(data + padding)


def jwt_encode(payload: dict, exp_seconds: int = 3600) -> str:
    header = {'alg': 'HS256', 'typ': 'JWT'}
    payload = payload.copy()
    payload['exp'] = int(time.time()) + exp_seconds
    header_b64 = _base64url_encode(json.dumps(header, separators=(',', ':')).encode())
    payload_b64 = _base64url_encode(json.dumps(payload, separators=(',', ':')).encode())
    signing_input = f"{header_b64}.{payload_b64}".encode()
    signature = hmac.new(SECRET_KEY.encode(), signing_input, hashlib.sha256).digest()
    sig_b64 = _base64url_encode(signature)
    return f"{header_b64}.{payload_b64}.{sig_b64}"


def jwt_decode(token: str) -> Optional[dict]:
    try:
        header_b64, payload_b64, sig_b64 = token.split('.')
        signing_input = f"{header_b64}.{payload_b64}".encode()
        expected_sig = hmac.new(SECRET_KEY.encode(), signing_input, hashlib.sha256).digest()
        if not hmac.compare_digest(expected_sig, _base64url_decode(sig_b64)):
            return None
        payload_bytes = _base64url_decode(payload_b64)
        payload = json.loads(payload_bytes.decode('utf-8'))
        if payload.get('exp') and int(time.time()) > payload['exp']:
            return None
        return payload
    except Exception:
        return None


def jwt_required(role: Optional[str] = None):
    """Flask decorator to require a valid JWT for an endpoint.

    If ``role`` is specified, the token must include a matching role
    (e.g. ``admin``).
    """
    def decorator(fn):
        @wraps(fn)
        def wrapper(*args, **kwargs):
            auth_header = request.headers.get('Authorization', '')
            if not auth_header.startswith('Bearer '):
                return jsonify({'error': 'Missing or invalid Authorization header'}), 401
            token = auth_header.split(' ', 1)[1]
            payload = jwt_decode(token)
            if not payload:
                return jsonify({'error': 'Invalid or expired token'}), 401
            if role and payload.get('role') != role:
                return jsonify({'error': 'Insufficient privileges'}), 403
            # Attach payload to request context for downstream use
            request.user = payload
            return fn(*args, **kwargs)
        return wrapper
    return decorator