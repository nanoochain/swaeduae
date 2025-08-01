from flask import Blueprint, jsonify, request, current_app
from sawaed_app import db
from sawaed_app.models import Event, EventVolunteer

events_bp = Blueprint('events', __name__)

@events_bp.route('/events', methods=['GET'])
def list_events():
    try:
        events = Event.query.all()
        result = []
        for e in events:
            result.append({
                "id": e.id,
                "title": e.title,
                "date": str(e.date),
                "description": e.description,
                "location": e.location
            })
        return jsonify(result)
    except Exception as ex:
        current_app.logger.error(f"/events error: {ex}")
        return jsonify({"error": str(ex)}), 500

@events_bp.route('/events/register', methods=['POST'])
def register_for_event():
    data = request.get_json()
    event_id = data.get('event_id')
    user_id = data.get('user_id')
    if not event_id or not user_id:
        return jsonify({"error": "Missing event_id or user_id"}), 400
    try:
        existing = EventVolunteer.query.filter_by(event_id=event_id, user_id=user_id).first()
        if existing:
            return jsonify({"message": "Already registered"}), 200
        ev = EventVolunteer(event_id=event_id, user_id=user_id, status="pending")
        db.session.add(ev)
        db.session.commit()
        return jsonify({"message": "Registered successfully"})
    except Exception as ex:
        current_app.logger.error(f"/events/register error: {ex}")
        return jsonify({"error": str(ex)}), 500
