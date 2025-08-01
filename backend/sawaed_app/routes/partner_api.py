from flask import Blueprint, request, jsonify
from ..models import db, Event, User
from flask_jwt_extended import jwt_required, get_jwt_identity

partner_api_bp = Blueprint('partner_api', __name__)

# Only accessible with API key (check header "X-API-KEY")
@partner_api_bp.before_request
def require_api_key():
    key = request.headers.get("X-API-KEY")
    if not key or key != "replace-with-your-real-partner-key":
        return jsonify({"error": "Invalid API Key"}), 403

@partner_api_bp.route("/api/partner/events", methods=["POST"])
def create_event():
    data = request.json
    event = Event(
        name=data.get("name"),
        description=data.get("description"),
        date=data.get("date"),
        location=data.get("location"),
        created_by=data.get("created_by"),
    )
    db.session.add(event)
    db.session.commit()
    return jsonify({"success": True, "event_id": event.id})

@partner_api_bp.route("/api/partner/events", methods=["GET"])
def list_events():
    events = Event.query.all()
    return jsonify([{"id": e.id, "name": e.name, "date": e.date.isoformat()} for e in events])
