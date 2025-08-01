from flask import Blueprint, jsonify
from ..models import db, User, Event, Certificate, VolunteerHour

admin_stats_bp = Blueprint('admin_stats', __name__)

@admin_stats_bp.route("/api/admin/stats")
def admin_stats():
    users = db.session.query(User).count()
    events = db.session.query(Event).count()
    certificates = db.session.query(Certificate).count()
    hours = db.session.query(VolunteerHour).count()
    return jsonify({
        "users": users,
        "events": events,
        "certificates": certificates,
        "hours": hours,
    })
