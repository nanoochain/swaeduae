from flask import Blueprint, request, jsonify
from sawaed_app.models import db, User, VolunteerRegistration, VolunteerEvent
from flask_jwt_extended import jwt_required, get_jwt_identity

volunteer_bp = Blueprint('volunteer_bp', __name__)

@volunteer_bp.route('/volunteer/register', methods=['POST'])
@jwt_required()
def register_for_event():
    user_id = get_jwt_identity()
    data = request.get_json()
    event_id = data.get('event_id')
    if not event_id:
        return jsonify({"msg": "Event ID required"}), 400
    registration = VolunteerRegistration(user_id=user_id, event_id=event_id)
    db.session.add(registration)
    db.session.commit()
    return jsonify({"msg": "Registered successfully"}), 200

@volunteer_bp.route('/volunteer/profile', methods=['GET'])
@jwt_required()
def volunteer_profile():
    user_id = get_jwt_identity()
    user = User.query.get(user_id)
    if not user:
        return jsonify({"msg": "User not found"}), 404
    return jsonify({
        "username": user.username,
        "email": user.email,
        "role": user.role,
        "created_at": user.created_at.isoformat()
    })
