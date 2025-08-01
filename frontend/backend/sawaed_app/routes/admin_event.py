from flask import Blueprint, request, jsonify
from ..models import db, EventVolunteer, User
from flask_jwt_extended import jwt_required

admin_event_bp = Blueprint('admin_event', __name__)

@admin_event_bp.route("/admin/event_volunteers", methods=["GET"])
@jwt_required()
def event_volunteers():
    event_id = request.args.get("event_id")
    vols = EventVolunteer.query.filter_by(event_id=event_id).all()
    data = []
    for v in vols:
        user = User.query.get(v.user_id)
        data.append({
            "id": v.id,
            "user_id": v.user_id,
            "user_email": user.email if user else "",
            "status": v.status,
        })
    return jsonify(data)

@admin_event_bp.route("/admin/approve_volunteer", methods=["POST"])
@jwt_required()
def approve_volunteer():
    event_id = request.json.get("event_id")
    user_id = request.json.get("user_id")
    vol = EventVolunteer.query.filter_by(event_id=event_id, user_id=user_id).first()
    if not vol:
        return jsonify({"error": "Not found"}), 404
    vol.status = "approved"
    db.session.commit()
    return jsonify({"status": "approved"})
