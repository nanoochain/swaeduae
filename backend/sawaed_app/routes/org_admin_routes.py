from flask import Blueprint, request, jsonify
from ..models import db, OrgApplicant, User, Event, Organization
from flask_jwt_extended import jwt_required, get_jwt_identity

org_admin_bp = Blueprint('org_admin_bp', __name__)

@org_admin_bp.route("/org/<int:org_id>/applicants", methods=["GET"])
@jwt_required()
def get_org_applicants(org_id):
    current_user = User.query.get(get_jwt_identity())
    if current_user.role not in ("org_admin", "admin") or (current_user.org_id != org_id and current_user.role != "admin"):
        return jsonify({"error": "Unauthorized"}), 403
    applicants = OrgApplicant.query.filter_by(org_id=org_id, status="pending").all()
    return jsonify({"applicants": [
        {
            "id": a.id,
            "user_id": a.user_id,
            "event": Event.query.get(a.event_id).name if a.event_id else None,
            "name": User.query.get(a.user_id).username if a.user_id else "",
            "email": User.query.get(a.user_id).email if a.user_id else "",
            "applied_at": a.applied_at.strftime('%Y-%m-%d')
        }
        for a in applicants
    ]})

@org_admin_bp.route("/org/applicant/<int:app_id>/approve", methods=["POST"])
@jwt_required()
def approve_applicant(app_id):
    app = OrgApplicant.query.get(app_id)
    if not app:
        return jsonify({"error": "Applicant not found"}), 404
    app.status = "approved"
    db.session.commit()
    return jsonify({"message": "Applicant approved"})

@org_admin_bp.route("/org/applicant/<int:app_id>/reject", methods=["POST"])
@jwt_required()
def reject_applicant(app_id):
    app = OrgApplicant.query.get(app_id)
    if not app:
        return jsonify({"error": "Applicant not found"}), 404
    app.status = "rejected"
    db.session.commit()
    return jsonify({"message": "Applicant rejected"})
