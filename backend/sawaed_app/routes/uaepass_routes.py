from flask import Blueprint, request, jsonify
import requests
import os

uaepass_bp = Blueprint('uaepass', __name__, url_prefix='/uaepass')

# Configuration - replace with your UAE PASS details
UAE_PASS_CLIENT_ID = os.getenv("UAE_PASS_CLIENT_ID", "your-client-id")
UAE_PASS_CLIENT_SECRET = os.getenv("UAE_PASS_CLIENT_SECRET", "your-client-secret")
UAE_PASS_TOKEN_URL = "https://oauth.uaepass.ae/token"  # Replace with actual UAE PASS token endpoint
UAE_PASS_SIGNATURE_API_URL = "https://api.uaepass.ae/signature"  # Replace with actual signature API endpoint

@uaepass_bp.route('/auth/token', methods=['POST'])
def get_access_token():
    data = {
        "client_id": UAE_PASS_CLIENT_ID,
        "client_secret": UAE_PASS_CLIENT_SECRET,
        "grant_type": "client_credentials"
    }
    response = requests.post(UAE_PASS_TOKEN_URL, data=data)
    if response.status_code == 200:
        return jsonify(response.json())
    else:
        return jsonify({"error": "Failed to get token"}), response.status_code

@uaepass_bp.route('/sign', methods=['POST'])
def request_signature():
    access_token = request.headers.get("Authorization")
    document = request.json.get("document")
    # Forward the signature request to UAE PASS API (mocked example)
    headers = {"Authorization": access_token}
    payload = {"document": document}
    response = requests.post(UAE_PASS_SIGNATURE_API_URL, json=payload, headers=headers)
    if response.status_code == 200:
        return jsonify(response.json())
    else:
        return jsonify({"error": "Signature request failed"}), response.status_code

