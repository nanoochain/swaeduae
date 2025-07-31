from flask import Blueprint, jsonify
from flask_jwt_extended import jwt_required, get_jwt_identity

protected_bp = Blueprint('protected', __name__)

@protected_bp.route('/dashboard', methods=['GET'])
@jwt_required()
def dashboard():
    current_user = get_jwt_identity()
    return jsonify({
        "message": f"Welcome {current_user['email']}!",
        "user": current_user
    })

@protected_bp.route('/admin/stats', methods=['GET'])
@jwt_required()
def admin_stats():
    current_user = get_jwt_identity()
    if current_user['role'] != 'admin':
        return jsonify({"message": "Access denied"}), 403

    return jsonify({
        "stats": {
            "users": 120,
            "events": 42,
            "certificates": 67
        },
        "admin": current_user['email']
    })
