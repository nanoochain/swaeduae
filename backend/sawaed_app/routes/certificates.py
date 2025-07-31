from flask import Blueprint, request, jsonify, send_file
from ..models import db, Certificate, User, DeliveryLog
from ..cert_utils import generate_certificate_pdf
from ..mail_utils import send_certificate_email
import os

cert_bp = Blueprint("certificates", __name__)

@cert_bp.route('/certificates/approve', methods=['POST'])
def approve_certificate():
    data = request.json
    cert_id = data['cert_id']
    cert = Certificate.query.get(cert_id)
    user = User.query.get(cert.user_id)
    cert.status = "approved"
    save_path = "/opt/swaeduae/certificates"
    os.makedirs(save_path, exist_ok=True)
    pdf_path = generate_certificate_pdf(cert, user, save_path)
    cert.pdf_path = pdf_path
    db.session.commit()
    return jsonify({"message": "Certificate approved & PDF generated.", "pdf_path": pdf_path})

@cert_bp.route('/certificates/send', methods=['POST'])
def send_certificate():
    data = request.json
    cert_id = data['cert_id']
    via = data['via']  # "email"
    cert = Certificate.query.get(cert_id)
    user = User.query.get(cert.user_id)
    # Send email
    if via == "email":
        send_certificate_email(user.email, cert.pdf_path)
        status = "sent"
    else:
        status = "unsupported"
    # Log
    log = DeliveryLog(cert_id=cert_id, user_id=user.id, delivered_via=via, status=status)
    db.session.add(log)
    db.session.commit()
    return jsonify({"message": "Certificate sent!", "status": status})

@cert_bp.route('/certificates/<int:cert_id>/pdf')
def get_certificate_pdf(cert_id):
    cert = Certificate.query.get(cert_id)
    if cert and cert.pdf_path:
        return send_file(cert.pdf_path, mimetype='application/pdf')
    return "Not found", 404

@cert_bp.route('/verify/<int:cert_id>')
def verify_certificate(cert_id):
    cert = Certificate.query.get(cert_id)
    if cert and cert.status == "approved":
        return jsonify({"status": "valid", "pdf_url": f"/certificates/{cert_id}/pdf"})
    return jsonify({"status": "invalid"})
