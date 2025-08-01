from flask import Blueprint, redirect, request, session, jsonify
import os, requests

social_oauth_bp = Blueprint('social_oauth', __name__)

GOOGLE_CLIENT_ID = os.environ.get("GOOGLE_CLIENT_ID", "your-google-client-id")
GOOGLE_CLIENT_SECRET = os.environ.get("GOOGLE_CLIENT_SECRET", "your-google-secret")
GOOGLE_REDIRECT_URI = os.environ.get("GOOGLE_REDIRECT_URI", "https://swaeduae.ae/auth/google/callback")

@social_oauth_bp.route("/auth/google/login")
def google_login():
    url = "https://accounts.google.com/o/oauth2/v2/auth"
    params = {
        "client_id": GOOGLE_CLIENT_ID,
        "redirect_uri": GOOGLE_REDIRECT_URI,
        "response_type": "code",
        "scope": "openid email profile"
    }
    return redirect(url + "?" + "&".join([f"{k}={v}" for k, v in params.items()]))

@social_oauth_bp.route("/auth/google/callback")
def google_callback():
    code = request.args.get("code")
    # Exchange code for token
    r = requests.post("https://oauth2.googleapis.com/token", data={
        "client_id": GOOGLE_CLIENT_ID,
        "client_secret": GOOGLE_CLIENT_SECRET,
        "code": code,
        "redirect_uri": GOOGLE_REDIRECT_URI,
        "grant_type": "authorization_code",
    })
    data = r.json()
    # Fetch userinfo, map to user, etc.
    return jsonify(data)
