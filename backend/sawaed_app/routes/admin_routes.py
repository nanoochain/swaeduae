from flask import Blueprint, jsonify, request
from sawaed_app.models import db, User, VolunteerEvent
from flask_jwt_extended import jwt_required

admin_bp = Blueprint('admin_bp', __name__)

@admin_bp.route('/admin/users', methods=['GET'])
@jwt_required()
def list_users():
    users = User.query.all()
    users_list = [{"id": u.id, "username": u.username, "email": u.email, "role": u.role} for u in users]
    return jsonify({"users": users_list})

@admin_bp.route('/admin/events', methods=['GET'])
@jwt_required()
def list_events():
    events = VolunteerEvent.query.all()
    events_list = [{"id": e.id, "name": e.name} for e in events]
    return jsonify({"events": events_list})

# Add endpoints to manage certificates, approvals, stats etc.

