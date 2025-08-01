from flask import Blueprint, request, jsonify, redirect
from flask_jwt_extended import create_access_token
import requests
import os

oauth_bp = Blueprint('oauth', __name__)

# Stub config - add real values later
UAEPASS_CLIENT_ID = os.getenv('UAEPASS_CLIENT_ID', 'your-client-id')
UAEPASS_CLIENT_SECRET = os.getenv('UAEPASS_CLIENT_SECRET', 'your-client-secret')
UAEPASS_REDIRECT_URI = os.getenv('UAEPASS_REDIRECT_URI', 'https://yourdomain.ae/auth/uaepass/callback')
UAEPASS_AUTH_URL = "https://id.uaepass.ae/oauth/2.0/authorize"
UAEPASS_TOKEN_URL = "https://id.uaepass.ae/oauth/2.0/token"
UAEPASS_USERINFO_URL = "https://id.uaepass.ae/oauth/2.0/userinfo"

@oauth_bp.route('/auth/uaepass/login')
def uaepass_login():
    # Redirect to UAE PASS OAuth2 authorization endpoint
    params = {
        'response_type': 'code',
        'client_id': UAEPASS_CLIENT_ID,
        'redirect_uri': UAEPASS_REDIRECT_URI,
        'scope': 'openid email',
        'state': 'optional-csrf-token',
    }
    url = UAEPASS_AUTH_URL + "?" + "&".join(f"{k}={v}" for k,v in params.items())
    return redirect(url)

@oauth_bp.route('/auth/uaepass/callback')
def uaepass_callback():
    code = request.args.get('code')
    if not code:
        return jsonify({"error": "No code provided"}), 400

    # Exchange code for access token (stub)
    data = {
        'grant_type': 'authorization_code',
        'code': code,
        'redirect_uri': UAEPASS_REDIRECT_URI,
        'client_id': UAEPASS_CLIENT_ID,
        'client_secret': UAEPASS_CLIENT_SECRET,
    }
    # In real, call requests.post(UAEPASS_TOKEN_URL, data=data) here
    # For now simulate token
    access_token = "mock_access_token"

    # In real, call requests.get(UAEPASS_USERINFO_URL, headers={"Authorization": "Bearer "+access_token})
    userinfo = {
        "sub": "mock-uaepass-id",
        "email": "user@example.ae",
        "name": "UAE PASS User"
    }

    # TODO: Lookup or create user in DB based on userinfo
    # For now just create JWT token and return
    jwt_token = create_access_token(identity=userinfo["email"])

    return jsonify({"access_token": jwt_token, "userinfo": userinfo})

