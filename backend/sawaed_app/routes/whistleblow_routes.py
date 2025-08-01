from flask import Blueprint, request, jsonify
from ..models import db, Whistleblow, User
from flask_jwt_extended import jwt_required, get_jwt_identity
from datetime import datetime

whistleblow_bp = Blueprint('whistleblow_bp', __name__)

@whistleblow_bp.route("/whistleblow", methods=["POST"])
@jwt_required()
def submit_whistleblow():
    user_id = get_jwt_identity()
    text = request.json.get("text")
    if not text:
        return jsonify({"error": "Text required"}), 400
    w = Whistleblow(user_id=user_id, text=text)
    db.session.add(w)
    db.session.commit()
    return jsonify({"message": "Whistleblowing report submitted"})

@whistleblow_bp.route("/admin/whistleblow", methods=["GET"])
@jwt_required()
def get_all_whistleblows():
    # Only admins
    admin = User.query.get(get_jwt_identity())
    if admin.role not in ("admin", "org_admin"):
        return jsonify({"error": "Unauthorized"}), 403
    items = Whistleblow.query.order_by(Whistleblow.submitted_at.desc()).all()
    return jsonify([{
        "id": w.id,
        "user_id": w.user_id,
        "text": w.text,
        "submitted_at": w.submitted_at.strftime('%Y-%m-%d %H:%M'),
        "reviewed": w.reviewed,
        "status": w.status
    } for w in items])
