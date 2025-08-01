from flask import Blueprint, redirect, url_for, request, session, jsonify
import os, requests

uaepass_bp = Blueprint('uaepass', __name__)

UAEPASS_CLIENT_ID = os.environ.get("UAEPASS_CLIENT_ID", "your-client-id")
UAEPASS_CLIENT_SECRET = os.environ.get("UAEPASS_CLIENT_SECRET", "your-client-secret")
UAEPASS_REDIRECT_URI = os.environ.get("UAEPASS_REDIRECT_URI", "https://swaeduae.ae/auth/uaepass/callback")
UAEPASS_AUTH_URL = "https://stg-id.uaepass.ae/idshub/authorize"
UAEPASS_TOKEN_URL = "https://stg-id.uaepass.ae/idshub/token"

@uaepass_bp.route("/auth/uaepass/login")
def uaepass_login():
    params = {
        "client_id": UAEPASS_CLIENT_ID,
        "redirect_uri": UAEPASS_REDIRECT_URI,
        "response_type": "code",
        "scope": "urn:uae:digitalid:profile openid"
    }
    url = UAEPASS_AUTH_URL + "?" + "&".join([f"{k}={v}" for k, v in params.items()])
    return redirect(url)

@uaepass_bp.route("/auth/uaepass/callback")
def uaepass_callback():
    code = request.args.get("code")
    data = {
        "grant_type": "authorization_code",
        "code": code,
        "redirect_uri": UAEPASS_REDIRECT_URI,
        "client_id": UAEPASS_CLIENT_ID,
        "client_secret": UAEPASS_CLIENT_SECRET,
    }
    r = requests.post(UAEPASS_TOKEN_URL, data=data)
    token_data = r.json()
    # TODO: Map user to local DB, create session/jwt, mark verified
    return jsonify(token_data)
