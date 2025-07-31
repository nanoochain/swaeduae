# events.py
from flask import Blueprint, request, jsonify
from flask_jwt_extended import jwt_required, get_jwt_identity
from sawaed_app.models import db, User, Event, EventRegistration
from datetime import datetime

events_bp = Blueprint('events_bp', __name__)

# Volunteer registers for an event
@events_bp.route('/events/register', methods=['POST'])
@jwt_required()
def register_for_event():
    data = request.json
    user_id = get_jwt_identity()
    event_id = data.get('event_id')

    if not event_id:
        return jsonify({"error": "Missing event_id"}), 400

    existing = EventRegistration.query.filter_by(user_id=user_id, event_id=event_id).first()
    if existing:
        return jsonify({"message": "Already registered"}), 200

    registration = EventRegistration(user_id=user_id, event_id=event_id)
    db.session.add(registration)
    db.session.commit()
    return jsonify({"message": "Registered successfully"}), 201

# Logged-in volunteer views their registered events
@events_bp.route('/my-events', methods=['GET'])
@jwt_required()
def get_my_events():
    user_id = get_jwt_identity()
    registrations = EventRegistration.query.filter_by(user_id=user_id).all()

    events = []
    for reg in registrations:
        event = reg.event
        events.append({
            "id": event.id,
            "title": event.title,
            "date": event.date.isoformat(),
            "location": event.location
        })

    return jsonify(events), 200

# Public access to view all events
@events_bp.route('/events/public', methods=['GET'])
def get_public_events():
    events = Event.query.all()
    data = []
    for ev in events:
        data.append({
            "id": ev.id,
            "title": ev.title,
            "date": ev.date.isoformat(),
            "location": ev.location
        })
    return jsonify(data), 200

# Admin sees all events with number of registrations
@events_bp.route('/admin/events', methods=['GET'])
@jwt_required()
def admin_event_list():
    current_user_id = get_jwt_identity()
    user = User.query.get(current_user_id)
    if user.role != 'admin':
        return jsonify({"error": "Unauthorized"}), 403

    events = Event.query.all()
    data = []
    for ev in events:
        data.append({
            "id": ev.id,
            "title": ev.title,
            "date": ev.date.isoformat(),
            "location": ev.location,
            "registrations": len(ev.registrations)
        })
    return jsonify(data), 200

# Admin gets list of registered volunteers for an event
@events_bp.route('/admin/events/<int:event_id>/volunteers', methods=['GET'])
@jwt_required()
def list_volunteers_for_event(event_id):
    current_user_id = get_jwt_identity()
    user = User.query.get(current_user_id)
    if user.role != 'admin':
        return jsonify({"error": "Unauthorized"}), 403

    registrations = EventRegistration.query.filter_by(event_id=event_id).all()
    data = []
    for reg in registrations:
        data.append({
            "id": reg.id,
            "user_id": reg.user_id,
            "username": reg.user.username,
            "email": reg.user.email,
            "is_approved": reg.is_approved
        })
    return jsonify(data), 200

# Admin approves a volunteer for an event
@events_bp.route('/admin/events/<int:event_id>/approve', methods=['POST'])
@jwt_required()
def approve_volunteer(event_id):
    current_user_id = get_jwt_identity()
    user = User.query.get(current_user_id)
    if user.role != 'admin':
        return jsonify({"error": "Unauthorized"}), 403

    reg_id = request.json.get('registration_id')
    registration = EventRegistration.query.filter_by(id=reg_id, event_id=event_id).first()
    if not registration:
        return jsonify({"error": "Registration not found"}), 404

    registration.is_approved = True
    db.session.commit()
    return jsonify({"message": "Volunteer approved."}), 200
