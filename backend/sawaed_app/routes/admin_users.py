from flask import Blueprint, request, jsonify
from ..models import db, User
from datetime import datetime

admin_users_bp = Blueprint('admin_users', __name__)

@admin_users_bp.route("/api/admin/users", methods=["GET"])
def list_users():
    query = User.query
    search = request.args.get("search")
    if search:
        query = query.filter(User.username.ilike(f"%{search}%"))
    users = query.all()
    return jsonify([u.to_dict() for u in users])

@admin_users_bp.route("/api/admin/users/bulk", methods=["POST"])
def bulk_action():
    data = request.json
    action = data.get("action")
    user_ids = data.get("user_ids", [])
    if action == "approve":
        User.query.filter(User.id.in_(user_ids)).update({"is_approved": True}, synchronize_session=False)
    elif action == "suspend":
        User.query.filter(User.id.in_(user_ids)).update({"is_active": False}, synchronize_session=False)
    elif action == "admin":
        User.query.filter(User.id.in_(user_ids)).update({"role": "admin"}, synchronize_session=False)
    elif action == "user":
        User.query.filter(User.id.in_(user_ids)).update({"role": "user"}, synchronize_session=False)
    elif action == "export":
        users = User.query.filter(User.id.in_(user_ids)).all()
        return jsonify([u.to_dict() for u in users])
    db.session.commit()
    return jsonify({"success": True})
