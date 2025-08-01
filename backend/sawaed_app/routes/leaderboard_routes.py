from flask import Blueprint, jsonify
from ..models import db, User, VolunteerHour, Event

leaderboard_bp = Blueprint('leaderboard', __name__)

@leaderboard_bp.route("/api/leaderboard", methods=["GET"])
def leaderboard():
    users = (
        db.session.query(
            User.id, User.username,
            db.func.sum(VolunteerHour.hours).label('hours'),
            db.func.count(VolunteerHour.event_id).label('events')
        )
        .join(VolunteerHour, VolunteerHour.user_id == User.id)
        .group_by(User.id)
        .order_by(db.desc('hours'))
        .limit(10)
        .all()
    )
    return jsonify([
        {"id": u.id, "username": u.username, "hours": int(u.hours or 0), "events": int(u.events or 0)}
        for u in users
    ])

@leaderboard_bp.route("/api/events", methods=["GET"])
def get_events():
    events = Event.query.filter(Event.latitude.isnot(None), Event.longitude.isnot(None)).all()
    return jsonify([
        {
            "id": e.id,
            "title": e.title,
            "latitude": e.latitude,
            "longitude": e.longitude,
            "date": e.date.strftime("%Y-%m-%d"),
            "location": e.location
        }
        for e in events
    ])
