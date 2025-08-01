import os
import requests
from flask import Blueprint, request, redirect, session, url_for, jsonify, current_app
from .models import db, User
from flask_jwt_extended import create_access_token

oauth_bp = Blueprint('oauth', __name__)

UAE_PASS_CLIENT_ID = os.environ.get('UAE_PASS_CLIENT_ID', '')
UAE_PASS_CLIENT_SECRET = os.environ.get('UAE_PASS_CLIENT_SECRET', '')
UAE_PASS_REDIRECT_URI = os.environ.get('UAE_PASS_REDIRECT_URI', 'https://swaeduae.ae/auth/uaepass/callback')
UAE_PASS_TOKEN_URL = "https://stg-id.uaepass.ae/idshub/token"
UAE_PASS_USERINFO_URL = "https://stg-id.uaepass.ae/idshub/userinfo"

@oauth_bp.route('/auth/uaepass/login')
def uaepass_login():
    state = os.urandom(16).hex()
    session['oauth_state'] = state
    auth_url = (
        "https://stg-id.uaepass.ae/idshub/authorize"
        f"?client_id={UAE_PASS_CLIENT_ID}"
        f"&redirect_uri={UAE_PASS_REDIRECT_URI}"
        "&response_type=code"
        "&scope=urn:uae:digitalid:profile:general"
        f"&state={state}"
    )
    return redirect(auth_url)

@oauth_bp.route('/auth/uaepass/callback')
def uaepass_callback():
    code = request.args.get('code')
    state = request.args.get('state')
    if state != session.get('oauth_state'):
        return "Invalid state", 400

    # Exchange code for token
    data = {
        "grant_type": "authorization_code",
        "code": code,
        "redirect_uri": UAE_PASS_REDIRECT_URI,
        "client_id": UAE_PASS_CLIENT_ID,
        "client_secret": UAE_PASS_CLIENT_SECRET
    }
    token_resp = requests.post(UAE_PASS_TOKEN_URL, data=data)
    if not token_resp.ok:
        return "Failed to fetch token", 400
    access_token = token_resp.json().get('access_token')
    # Fetch user info
    headers = {"Authorization": f"Bearer {access_token}"}
    userinfo_resp = requests.get(UAE_PASS_USERINFO_URL, headers=headers)
    if not userinfo_resp.ok:
        return "Failed to fetch user info", 400
    userinfo = userinfo_resp.json()

    # Find or create user
    email = userinfo.get("email", userinfo.get("sub"))
    user = User.query.filter_by(email=email).first()
    if not user:
        user = User(
            username=userinfo.get("name", "UAE PASS"),
            email=email,
            password_hash="uaepass",
            is_admin=False
        )
        db.session.add(user)
        db.session.commit()
    # Issue JWT token and redirect to frontend
    token = create_access_token(identity=user.id)
    return redirect(f"https://swaeduae.ae/login?token={token}&uaepass=1")
