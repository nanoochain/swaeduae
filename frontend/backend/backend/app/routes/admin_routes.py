# /opt/swaeduae/backend/app/routes/admin_routes.py

from flask import Blueprint, jsonify
from app.models import db, User, VolunteerEvent

admin_bp = Blueprint("admin", __name__)

@admin_bp.route("/admin/stats", methods=["GET"])
def admin_stats():
    total_users = User.query.count()
    total_events = VolunteerEvent.query.count()
    return jsonify({
        "total_users": total_users,
        "total_events": total_events
    })
