from flask import Blueprint, request, jsonify
from sawaed_app.models import db, Certificate, DeliveryLog
from datetime import datetime

certificate_bp = Blueprint('certificate_bp', __name__)

@certificate_bp.route('/certificates/send', methods=['POST'])
def send_certificate():
    data = request.get_json()
    cert_id = data.get('certificate_id')
    method = data.get('method')  # 'email' or 'whatsapp'

    certificate = Certificate.query.get(cert_id)
    if not certificate:
        return jsonify({'error': 'Certificate not found'}), 404

    # Simulated delivery logic
    status = 'sent'  # In real setup, integrate email/SMS API here

    log = DeliveryLog(
        certificate_id=cert_id,
        method=method,
        status=status,
        timestamp=datetime.utcnow()
    )
    db.session.add(log)

    certificate.delivery_status = status
    db.session.commit()

    return jsonify({'message': f'Certificate sent via {method}', 'status': status})

@certificate_bp.route('/verify/<int:cert_id>', methods=['GET'])
def verify_certificate(cert_id):
    cert = Certificate.query.get(cert_id)
    if not cert:
        return jsonify({'valid': False, 'message': 'Certificate not found'}), 404

    return jsonify({
        'valid': True,
        'volunteer_name': cert.volunteer_name,
        'event_name': cert.event_name,
        'issue_date': cert.issue_date.strftime("%Y-%m-%d")
    })
