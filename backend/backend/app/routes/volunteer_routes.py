# /opt/swaeduae/backend/app/routes/volunteer_routes.py

from flask import Blueprint, request, jsonify
from app.models import db, VolunteerEvent

volunteer_bp = Blueprint("volunteer", __name__)

@volunteer_bp.route("/events", methods=["GET"])
def get_events():
    events = VolunteerEvent.query.all()
    return jsonify([{"id": e.id, "title": e.title, "date": e.date} for e in events])
