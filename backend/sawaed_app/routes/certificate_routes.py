from flask import Blueprint, jsonify
from ..models import Certificate

certificates_bp = Blueprint("certificates_bp", __name__)

@certificates_bp.route("/", methods=["GET"])
def list_certificates():
    certificates = Certificate.query.all()
    return jsonify([{
        "id": c.id,
        "title": c.title,
        "recipient": c.recipient_name,
        "date": c.issue_date.isoformat() if c.issue_date else None,
    } for c in certificates])
