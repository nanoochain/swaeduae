from flask import Blueprint, request, jsonify
from ..models import db, VolunteerHour, VolunteerBadge, User
from flask_jwt_extended import jwt_required, get_jwt_identity
from datetime import datetime

volunteer_hours_bp = Blueprint('volunteer_hours_bp', __name__)

@volunteer_hours_bp.route("/volunteer/<int:user_id>/hours", methods=["GET"])
@jwt_required()
def get_volunteer_hours(user_id):
    logs = VolunteerHour.query.filter_by(user_id=user_id).order_by(VolunteerHour.date.desc()).all()
    total = sum([h.hours for h in logs])
    return jsonify({
        "logs": [
            {
                "event": h.event,
                "hours": h.hours,
                "date": h.date.strftime('%Y-%m-%d')
            } for h in logs
        ],
        "total": total
    })

@volunteer_hours_bp.route("/volunteer/<int:user_id>/hours", methods=["POST"])
@jwt_required()
def log_volunteer_hours(user_id):
    data = request.json
    hours = float(data.get('hours', 0))
    event = data.get('event', 'Other')
    if not hours or not event:
        return jsonify({"error": "Missing fields"}), 400
    entry = VolunteerHour(user_id=user_id, hours=hours, event=event)
    db.session.add(entry)
    db.session.commit()
    # Optional: Assign badges here (see below)
    return jsonify({"message": "Hours logged!"})

# Badges endpoint
BADGE_THRESHOLDS = [
    (100, "Platinum Service"),
    (50, "Gold Volunteer"),
    (25, "Silver Contributor"),
    (10, "Bronze Helper"),
]

@volunteer_hours_bp.route("/volunteer/<int:user_id>/badges", methods=["GET"])
@jwt_required()
def get_badges(user_id):
    total_hours = db.session.query(db.func.sum(VolunteerHour.hours)).filter_by(user_id=user_id).scalar() or 0
    badges = []
    for thresh, name in BADGE_THRESHOLDS:
        if total_hours >= thresh:
            badges.append(name)
            # Optionally: Award badge in DB
            if not VolunteerBadge.query.filter_by(user_id=user_id, badge_name=name).first():
                db.session.add(VolunteerBadge(user_id=user_id, badge_name=name))
    db.session.commit()
    return jsonify({"badges": badges, "total_hours": total_hours})
