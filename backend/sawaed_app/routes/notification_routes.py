"""
Routes for sending notifications via email and WhatsApp.

These endpoints wrap the helper functions in ``utils.notifications`` and
require appropriate configuration.  In a real deployment you might
restrict access to these endpoints to admin users or internal
services.
"""

from flask import Blueprint, request, jsonify

from ..utils.notifications import send_email, send_whatsapp_message

notification_bp = Blueprint("notification_bp", __name__)


@notification_bp.route("/email", methods=["POST"])
def send_email_route():
    """Send an email notification.

    Expects a JSON payload with ``recipient``, ``subject``, and
    ``body``.  Returns a success message when queued.
    """
    data = request.get_json() or {}
    recipient = data.get("recipient")
    subject = data.get("subject")
    body = data.get("body")
    if not all([recipient, subject, body]):
        return jsonify({"msg": "Missing required fields"}), 400
    try:
        send_email(recipient, subject, body)
        return jsonify({"msg": "Email sent"}), 200
    except Exception as exc:
        return jsonify({"error": str(exc)}), 500


@notification_bp.route("/whatsapp", methods=["POST"])
def send_whatsapp_route():
    """Send a WhatsApp notification via Twilio.

    Expects a JSON payload with ``to`` and ``body``.  Returns the
    message SID if successful.
    """
    data = request.get_json() or {}
    to = data.get("to")
    body = data.get("body")
    if not to or not body:
        return jsonify({"msg": "Missing required fields"}), 400
    try:
        sid = send_whatsapp_message(to, body)
        return jsonify({"msg": "WhatsApp message sent", "sid": sid}), 200
    except Exception as exc:
        return jsonify({"error": str(exc)}), 500