from flask import Blueprint, request, jsonify
from ..models import VolunteerEvent
from ..extensions import db

events_bp = Blueprint('events', __name__)

@events_bp.route('/events', methods=['GET'])
def get_events():
    events = VolunteerEvent.query.all()
    events_data = []
    for event in events:
        events_data.append({
            "id": event.id,
            "name": event.name,
            "description": event.description,
            "date": event.date,
            "location": event.location,
        })
    return jsonify(events_data), 200

@events_bp.route('/events', methods=['POST'])
def create_event():
    data = request.get_json()
    event = VolunteerEvent(
        name=data.get('name'),
        description=data.get('description'),
        date=data.get('date'),
        location=data.get('location')
    )
    db.session.add(event)
    db.session.commit()
    return jsonify({"message": "Event created", "id": event.id}), 201

@events_bp.route('/events/<int:event_id>', methods=['GET'])
def get_event(event_id):
    event = VolunteerEvent.query.get_or_404(event_id)
    return jsonify({
        "id": event.id,
        "name": event.name,
        "description": event.description,
        "date": event.date,
        "location": event.location,
    }), 200

@events_bp.route('/events/<int:event_id>', methods=['PUT'])
def update_event(event_id):
    event = VolunteerEvent.query.get_or_404(event_id)
    data = request.get_json()
    event.name = data.get('name', event.name)
    event.description = data.get('description', event.description)
    event.date = data.get('date', event.date)
    event.location = data.get('location', event.location)
    db.session.commit()
    return jsonify({"message": "Event updated"}), 200

@events_bp.route('/events/<int:event_id>', methods=['DELETE'])
def delete_event(event_id):
    event = VolunteerEvent.query.get_or_404(event_id)
    db.session.delete(event)
    db.session.commit()
    return jsonify({"message": "Event deleted"}), 200
