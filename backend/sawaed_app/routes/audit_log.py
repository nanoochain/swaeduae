from flask import Blueprint, request, jsonify
from ..models import db, AuditLog
from flask_jwt_extended import get_jwt_identity, jwt_required

audit_log_bp = Blueprint('audit_log', __name__)

@audit_log_bp.route("/api/audit-log", methods=["GET"])
@jwt_required()
def view_audit_log():
    logs = AuditLog.query.order_by(AuditLog.timestamp.desc()).limit(100).all()
    return jsonify([log.to_dict() for log in logs])
