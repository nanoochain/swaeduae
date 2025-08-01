from flask import Blueprint, request, jsonify
from sawaed_app.models import db, VolunteerEvent

event_bp = Blueprint('event', __name__)

@event_bp.route('/events', methods=['GET'])
def list_events():
    events = VolunteerEvent.query.all()
    return jsonify([{
        "id": e.id,
        "title": e.title,
        "description": e.description,
        "date": e.date
    } for e in events])

@event_bp.route('/events', methods=['POST'])
def create_event():
    data = request.get_json()
    event = VolunteerEvent(
        title=data.get("title"),
        description=data.get("description"),
        date=data.get("date")
    )
    db.session.add(event)
    db.session.commit()
    return jsonify({"message": "Event created", "event_id": event.id}), 201
