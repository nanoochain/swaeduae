from flask import Blueprint, send_file, jsonify
import os

logs_bp = Blueprint('logs', __name__)

@logs_bp.route("/api/logs")
def download_log():
    log_path = os.path.join(os.path.dirname(__file__), '../../logs/app.log')
    if not os.path.exists(log_path):
        return jsonify({"error": "Log file not found"}), 404
    return send_file(log_path, mimetype="text/plain", as_attachment=False)
