from flask import Blueprint, jsonify
from sawaed_app.models import VolunteerEvent

event_bp = Blueprint('event_bp', __name__)

@event_bp.route('/events', methods=['GET'])
def get_events():
    events = VolunteerEvent.query.all()
    events_list = [{
        "id": e.id,
        "name": e.name,
        "start_date": e.start_date.isoformat() if e.start_date else None,
        "end_date": e.end_date.isoformat() if e.end_date else None,
    } for e in events]
    return jsonify({"events": events_list})
