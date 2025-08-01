from flask import Blueprint, request, jsonify, send_file
from ..models import db, User, Event, Certificate, DeliveryLog, KYCSubmission
from ..utils.email_utils import send_bulk_email
import csv
from io import StringIO
from datetime import datetime, timedelta

admin_bp = Blueprint('admin', __name__)

@admin_bp.route("/admin/stats", methods=["GET"])
def get_admin_stats():
    stats = {
        "users": User.query.count(),
        "events": Event.query.count(),
        "certificates": Certificate.query.count(),
        "kyc_pending": KYCSubmission.query.filter_by(status="pending").count(),
        "activity": [{"date": (datetime.utcnow()-timedelta(days=i)).strftime("%Y-%m-%d"), "logins": User.query.filter(User.id>0).count()} for i in range(7)],
    }
    return jsonify(stats)

@admin_bp.route("/admin/delivery_logs", methods=["GET"])
def get_delivery_logs():
    logs = DeliveryLog.query.order_by(DeliveryLog.sent_at.desc()).limit(100).all()
    result = []
    for log in logs:
        user = User.query.get(Certificate.query.get(log.cert_id).user_id)
        result.append({
            "user_email": user.email if user else "N/A",
            "cert_id": log.cert_id,
            "method": log.method,
            "status": log.status,
            "sent_at": log.sent_at.strftime("%Y-%m-%d %H:%M"),
        })
    return jsonify(result)

@admin_bp.route("/admin/delivery_logs/export", methods=["GET"])
def export_delivery_logs():
    logs = DeliveryLog.query.order_by(DeliveryLog.sent_at.desc()).all()
    si = StringIO()
    cw = csv.writer(si)
    cw.writerow(["User Email", "Cert ID", "Method", "Status", "Sent At"])
    for log in logs:
        user = User.query.get(Certificate.query.get(log.cert_id).user_id)
        cw.writerow([
            user.email if user else "N/A",
            log.cert_id,
            log.method,
            log.status,
            log.sent_at.strftime("%Y-%m-%d %H:%M"),
        ])
    output = si.getvalue().encode("utf-8")
    return send_file(
        StringIO(output.decode()), mimetype="text/csv", as_attachment=True, download_name="delivery_logs.csv"
    )

@admin_bp.route("/admin/bulk_message", methods=["POST"])
def bulk_message():
    data = request.json
    emails = [u.email for u in User.query.all() if u.role == "volunteer"]
    send_bulk_email(emails, data.get("subject", "Sawaed UAE"), data.get("message", ""))
    return jsonify({"status": "sent"})

from ..models import DeliveryLog
from flask import jsonify

@bp.route('/admin/delivery_logs')
def get_delivery_logs():
    logs = DeliveryLog.query.all()
    return jsonify([
        {
            "id": l.id,
            "cert_id": l.cert_id,
            "user_id": l.user_id,
            "delivered_via": l.delivered_via,
            "status": l.status,
            "timestamp": l.timestamp.isoformat()
        } for l in logs
    ])
