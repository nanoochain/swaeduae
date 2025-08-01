from flask import Blueprint, request, jsonify
from flask_jwt_extended import jwt_required
from sawaed_app.models import db, User, KYCSubmission, VolunteerApproval, Certificate, SystemLog
from datetime import datetime

admin_dash_bp = Blueprint('admin_dash', __name__)

# Get KYC submissions
@admin_dash_bp.route('/admin/kyc_submissions', methods=['GET'])
@jwt_required()
def get_kyc_submissions():
    submissions = KYCSubmission.query.all()
    result = [{
        "id": sub.id,
        "user_id": sub.user_id,
        "document_url": sub.document_url,
        "status": sub.status,
        "submitted_at": sub.submitted_at.isoformat() if sub.submitted_at else None
    } for sub in submissions]
    return jsonify({"kyc_submissions": result})

# Approve or Reject KYC
@admin_dash_bp.route('/admin/kyc_submissions/<int:submission_id>', methods=['POST'])
@jwt_required()
def update_kyc_submission(submission_id):
    data = request.json
    submission = KYCSubmission.query.get_or_404(submission_id)
    if "status" in data and data["status"] in ["approved", "rejected"]:
        submission.status = data["status"]
        db.session.commit()
        return jsonify({"message": f"KYC submission {data['status']}"})
    return jsonify({"error": "Invalid status"}), 400

# Get Volunteer Approvals
@admin_dash_bp.route('/admin/volunteer_approvals', methods=['GET'])
@jwt_required()
def get_volunteer_approvals():
    approvals = VolunteerApproval.query.all()
    result = [{
        "id": app.id,
        "user_id": app.user_id,
        "event_id": app.event_id,
        "status": app.status,
        "applied_at": app.applied_at.isoformat() if app.applied_at else None
    } for app in approvals]
    return jsonify({"volunteer_approvals": result})

# Approve or Reject Volunteer Application
@admin_dash_bp.route('/admin/volunteer_approvals/<int:approval_id>', methods=['POST'])
@jwt_required()
def update_volunteer_approval(approval_id):
    data = request.json
    approval = VolunteerApproval.query.get_or_404(approval_id)
    if "status" in data and data["status"] in ["approved", "rejected"]:
        approval.status = data["status"]
        db.session.commit()
        return jsonify({"message": f"Volunteer application {data['status']}"})
    return jsonify({"error": "Invalid status"}), 400

# List Certificates
@admin_dash_bp.route('/admin/certificates', methods=['GET'])
@jwt_required()
def list_certificates():
    certificates = Certificate.query.all()
    result = [{
        "id": cert.id,
        "user_id": cert.user_id,
        "event_id": cert.event_id,
        "issued_at": cert.issued_at.isoformat() if cert.issued_at else None,
        "cert_url": cert.cert_url
    } for cert in certificates]
    return jsonify({"certificates": result})

# Create Certificate for a volunteer for an event
@admin_dash_bp.route('/admin/certificates', methods=['POST'])
@jwt_required()
def create_certificate():
    data = request.json
    user_id = data.get("user_id")
    event_id = data.get("event_id")
    if not user_id or not event_id:
        return jsonify({"error": "Missing user_id or event_id"}), 400
    cert = Certificate(user_id=user_id, event_id=event_id, issued_at=datetime.utcnow(), cert_url="URL_PLACEHOLDER")
    db.session.add(cert)
    db.session.commit()
    return jsonify({"message": "Certificate created", "certificate_id": cert.id})

# System Logs (basic)
@admin_dash_bp.route('/admin/logs', methods=['GET'])
@jwt_required()
def get_logs():
    logs = SystemLog.query.order_by(SystemLog.timestamp.desc()).limit(100).all()
    result = [{"id": log.id, "message": log.message, "timestamp": log.timestamp.isoformat()} for log in logs]
    return jsonify({"logs": result})


# List Certificates (already added in prev step, just for clarity)
@admin_dash_bp.route('/admin/certificates', methods=['GET'])
@jwt_required()
def list_certificates():
    certificates = Certificate.query.all()
    result = [{
        "id": cert.id,
        "user_id": cert.user_id,
        "event_id": cert.event_id,
        "issued_at": cert.issued_at.isoformat() if cert.issued_at else None,
        "cert_url": cert.cert_url
    } for cert in certificates]
    return jsonify({"certificates": result})

# Create Certificate for a volunteer for an event
@admin_dash_bp.route('/admin/certificates', methods=['POST'])
@jwt_required()
def create_certificate():
    data = request.json
    user_id = data.get("user_id")
    event_id = data.get("event_id")
    if not user_id or not event_id:
        return jsonify({"error": "Missing user_id or event_id"}), 400
    cert = Certificate(user_id=user_id, event_id=event_id, issued_at=datetime.utcnow(), cert_url="URL_PLACEHOLDER")
    db.session.add(cert)
    db.session.commit()
    return jsonify({"message": "Certificate created", "certificate_id": cert.id})

# System Logs (basic)
@admin_dash_bp.route('/admin/logs', methods=['GET'])
@jwt_required()
def get_logs():
    logs = SystemLog.query.order_by(SystemLog.timestamp.desc()).limit(100).all()
    result = [{"id": log.id, "message": log.message, "timestamp": log.timestamp.isoformat()} for log in logs]
    return jsonify({"logs": result})

