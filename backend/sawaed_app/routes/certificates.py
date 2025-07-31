from flask import Blueprint, request, jsonify, send_file, current_app
from sawaed_app.models import db, Certificate
from io import BytesIO
from reportlab.pdfgen import canvas
import qrcode
import os
import smtplib
from email.message import EmailMessage

cert_bp = Blueprint('certificates', __name__)

@cert_bp.route('/certificates/send', methods=['POST'])
def send_certificate():
    data = request.json
    user_name = data.get('name')
    user_email = data.get('email')
    event_title = data.get('event')
    
    # 1. Generate certificate PDF
    buffer = BytesIO()
    p = canvas.Canvas(buffer)
    p.drawString(100, 750, f"Certificate of Appreciation")
    p.drawString(100, 730, f"Awarded to: {user_name}")
    p.drawString(100, 710, f"For participating in: {event_title}")
    p.save()
    buffer.seek(0)

    # 2. Save to DB
    cert = Certificate(name=user_name, email=user_email, event=event_title)
    db.session.add(cert)
    db.session.commit()

    # 3. Send by email (basic example)
    if os.environ.get('MAIL_SERVER'):
        msg = EmailMessage()
        msg['Subject'] = f"Your Certificate from {event_title}"
        msg['From'] = os.environ.get('MAIL_FROM')
        msg['To'] = user_email
        msg.set_content(f"Dear {user_name},\n\nThank you for participating in {event_title}.\n\nAttached is your certificate.")
        msg.add_attachment(buffer.getvalue(), maintype='application', subtype='pdf', filename='certificate.pdf')

        with smtplib.SMTP(os.environ['MAIL_SERVER'], int(os.environ.get('MAIL_PORT', 587))) as smtp:
            smtp.starttls()
            smtp.login(os.environ['MAIL_USER'], os.environ['MAIL_PASS'])
            smtp.send_message(msg)

    return jsonify({"message": "Certificate sent and saved.", "certificate_id": cert.id})


@cert_bp.route('/certificates/verify/<int:cert_id>', methods=['GET'])
def verify_certificate(cert_id):
    cert = Certificate.query.get(cert_id)
    if not cert:
        return jsonify({"error": "Certificate not found."}), 404
    return jsonify({
        "name": cert.name,
        "email": cert.email,
        "event": cert.event,
        "issued_on": cert.created_at.strftime("%Y-%m-%d")
    })
