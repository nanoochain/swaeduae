from flask import Blueprint, jsonify
from sawaed_app.models import db, User, Event, Certificate, DeliveryLog

admin_bp = Blueprint('admin_bp', __name__)

@admin_bp.route('/admin/stats', methods=['GET'])
def admin_stats():
    return jsonify({
        'total_users': User.query.count(),
        'total_events': Event.query.count(),
        'total_certificates': Certificate.query.count(),
        'delivered': Certificate.query.filter_by(delivery_status='sent').count(),
        'pending': Certificate.query.filter_by(delivery_status='pending').count(),
        'failed': Certificate.query.filter_by(delivery_status='failed').count()
    })
