"""
Authentication and authorization routes.

These routes provide JWT‑based sign‑up, login, and token refresh.  They
demonstrate how to interact with SQLAlchemy models and handle JSON
payloads.  Additional validation and password hashing should be
implemented in a production environment.
"""

from flask import Blueprint, request, jsonify
from flask_jwt_extended import (
    create_access_token,
    create_refresh_token,
    jwt_required,
    get_jwt_identity,
)

from ..extensions import db
from ..models import User

auth_bp = Blueprint("auth_bp", __name__)


@auth_bp.route("/signup", methods=["POST"])
def signup():
    """Register a new user.

    Expects a JSON body with ``username``, ``email``, and ``password`` keys.
    Returns a success message when the user is created.
    """
    data = request.get_json() or {}
    email: str | None = data.get("email")
    username: str | None = data.get("username")
    password: str | None = data.get("password")

    if not email or not username or not password:
        return jsonify({"msg": "Missing required fields"}), 400

    # Check for existing user
    if User.query.filter_by(email=email).first() or User.query.filter_by(username=username).first():
        return jsonify({"msg": "User already exists"}), 400

    # NOTE: In production you should hash passwords before storing them
    new_user = User(email=email, username=username, password_hash=password, role="volunteer")
    db.session.add(new_user)
    db.session.commit()
    return jsonify({"msg": "User registered", "email": email}), 201


@auth_bp.route("/login", methods=["POST"])
def login():
    """Authenticate a user and issue JWT tokens.

    Expects a JSON body with ``email`` and ``password``.  Returns both
    access and refresh tokens when credentials are valid.
    """
    data = request.get_json() or {}
    email: str | None = data.get("email")
    password: str | None = data.get("password")

    user = User.query.filter_by(email=email).first() if email else None
    if not user or user.password_hash != password:
        return jsonify({"msg": "Invalid credentials"}), 401

    access_token = create_access_token(identity={"id": user.id, "role": user.role}, fresh=True)
    refresh_token = create_refresh_token(identity={"id": user.id, "role": user.role})
    return jsonify({"access_token": access_token, "refresh_token": refresh_token}), 200


@auth_bp.route("/refresh", methods=["POST"])
@jwt_required(refresh=True)
def refresh():
    """Issue a new access token from a refresh token."""
    identity = get_jwt_identity()
    new_access_token = create_access_token(identity=identity)
    return jsonify({"access_token": new_access_token}), 200