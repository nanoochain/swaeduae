from flask import Blueprint, jsonify
from ..models import Event

events_bp = Blueprint("events_bp", __name__)

@events_bp.route("/", methods=["GET"])
def list_events():
    events = Event.query.all()
    return jsonify([{
        "id": e.id,
        "name": e.name,
        "date": e.date.isoformat() if e.date else None,
        "location": e.location,
    } for e in events])
