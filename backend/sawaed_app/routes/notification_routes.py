from flask import Blueprint, request, jsonify
import requests
import os

notification_bp = Blueprint('notification', __name__)

WHATSAPP_API_URL = os.environ.get("WHATSAPP_API_URL")
WHATSAPP_TOKEN = os.environ.get("WHATSAPP_TOKEN")
SMS_API_URL = os.environ.get("SMS_API_URL")
SMS_API_KEY = os.environ.get("SMS_API_KEY")

@notification_bp.route('/notify/whatsapp', methods=['POST'])
def notify_whatsapp():
    data = request.json
    to = data.get("to")
    message = data.get("message")
    # Example: Use WhatsApp Business API
    resp = requests.post(
        WHATSAPP_API_URL,
        headers={"Authorization": f"Bearer {WHATSAPP_TOKEN}"},
        json={"to": to, "type": "text", "text": {"body": message}}
    )
    return jsonify(resp.json()), resp.status_code

@notification_bp.route('/notify/sms', methods=['POST'])
def notify_sms():
    data = request.json
    to = data.get("to")
    message = data.get("message")
    # Example: Use Twilio or local SMS provider
    resp = requests.post(
        SMS_API_URL,
        headers={"Authorization": f"Bearer {SMS_API_KEY}"},
        json={"to": to, "body": message}
    )
    return jsonify(resp.json()), resp.status_code
