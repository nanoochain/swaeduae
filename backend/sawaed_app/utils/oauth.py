import os
import requests
from urllib.parse import urlencode

UAE_PASS_AUTH_URL = "https://stg-id.uaepass.ae/idshub/authorize"
UAE_PASS_TOKEN_URL = "https://stg-id.uaepass.ae/idshub/token"
UAE_PASS_USERINFO_URL = "https://stg-id.uaepass.ae/idshub/userinfo"

CLIENT_ID = os.getenv("UAE_PASS_CLIENT_ID")
CLIENT_SECRET = os.getenv("UAE_PASS_CLIENT_SECRET")
REDIRECT_URI = os.getenv("UAE_PASS_REDIRECT_URI")

def get_uae_pass_login_url():
    params = {
        "client_id": CLIENT_ID,
        "response_type": "code",
        "scope": "urn:uae:digitalid:profile",
        "redirect_uri": REDIRECT_URI,
        "state": "xyz123"
    }
    return f"{UAE_PASS_AUTH_URL}?{urlencode(params)}"

def exchange_code_for_token(code):
    data = {
        "grant_type": "authorization_code",
        "code": code,
        "redirect_uri": REDIRECT_URI,
        "client_id": CLIENT_ID,
        "client_secret": CLIENT_SECRET
    }
    response = requests.post(UAE_PASS_TOKEN_URL, data=data)
    return response.json()

def get_user_info(access_token):
    headers = {
        "Authorization": f"Bearer {access_token}"
    }
    response = requests.get(UAE_PASS_USERINFO_URL, headers=headers)
    return response.json()
