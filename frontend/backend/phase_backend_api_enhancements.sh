#!/bin/bash

echo "🚀 Starting Backend API Enhancements..."

cd /opt/swaeduae/backend

# 1. Update models.py with delivery status and log model
echo "📦 Updating models.py..."
cat << 'PYTHON' >> sawaed_app/models.py

from datetime import datetime

class DeliveryLog(db.Model):
    id = db.Column(db.Integer, primary_key=True)
    certificate_id = db.Column(db.Integer, db.ForeignKey('certificate.id'), nullable=False)
    method = db.Column(db.String(10))  # 'email' or 'whatsapp'
    status = db.Column(db.String(20))  # 'sent', 'pending', 'failed'
    timestamp = db.Column(db.DateTime, default=datetime.utcnow)

Certificate.delivery_status = db.Column(db.String(20), default='pending')  # pending, sent, failed
PYTHON

# 2. Add /certificates/send and /verify/<cert_id> endpoints
echo "📦 Updating certificate routes..."
cat << 'PYTHON' > sawaed_app/routes/certificate_routes.py
from flask import Blueprint, request, jsonify
from sawaed_app.models import db, Certificate, DeliveryLog
from datetime import datetime

certificate_bp = Blueprint('certificate_bp', __name__)

@certificate_bp.route('/certificates/send', methods=['POST'])
def send_certificate():
    data = request.get_json()
    cert_id = data.get('certificate_id')
    method = data.get('method')  # 'email' or 'whatsapp'

    certificate = Certificate.query.get(cert_id)
    if not certificate:
        return jsonify({'error': 'Certificate not found'}), 404

    # Simulated delivery logic
    status = 'sent'  # In real setup, integrate email/SMS API here

    log = DeliveryLog(
        certificate_id=cert_id,
        method=method,
        status=status,
        timestamp=datetime.utcnow()
    )
    db.session.add(log)

    certificate.delivery_status = status
    db.session.commit()

    return jsonify({'message': f'Certificate sent via {method}', 'status': status})

@certificate_bp.route('/verify/<int:cert_id>', methods=['GET'])
def verify_certificate(cert_id):
    cert = Certificate.query.get(cert_id)
    if not cert:
        return jsonify({'valid': False, 'message': 'Certificate not found'}), 404

    return jsonify({
        'valid': True,
        'volunteer_name': cert.volunteer_name,
        'event_name': cert.event_name,
        'issue_date': cert.issue_date.strftime("%Y-%m-%d")
    })
PYTHON

# 3. Update app to register the new blueprint
echo "📦 Registering new certificate routes in __init__.py..."
sed -i "/from .routes import/i from .routes import certificate_routes" sawaed_app/__init__.py
sed -i "/app.register_blueprint(auth_routes.auth_bp)/a \ \ \ \ app.register_blueprint(certificate_routes.certificate_bp)" sawaed_app/__init__.py

# 4. Improve /admin/stats with delivery counts
echo "📦 Enhancing admin stats..."
cat << 'PYTHON' > sawaed_app/routes/admin_routes.py
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
PYTHON

# 5. Re-register admin_routes
echo "📦 Registering updated admin routes..."
sed -i "/from .routes import/i from .routes import admin_routes" sawaed_app/__init__.py
sed -i "/app.register_blueprint(auth_routes.auth_bp)/a \ \ \ \ app.register_blueprint(admin_routes.admin_bp)" sawaed_app/__init__.py

# 6. Run migrations
echo "🛠️ Running DB migration..."
source venv/bin/activate
python3 -c "from sawaed_app import db, create_app; db.init_app(create_app()); app = create_app(); ctx = app.app_context(); ctx.push(); db.create_all()"

# 7. Commit and push
echo "📤 Committing changes to GitHub..."
git add sawaed_app/models.py sawaed_app/routes/certificate_routes.py sawaed_app/routes/admin_routes.py sawaed_app/__init__.py
git commit -m "✨ Backend API Enhancements: /certificates/send, /verify, /admin/stats update"
git push origin main

echo "✅ Done! Backend API enhancements applied."
