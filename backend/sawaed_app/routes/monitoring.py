from flask import Blueprint, jsonify
import psutil

monitoring_bp = Blueprint('monitoring', __name__)

@monitoring_bp.route("/api/admin/health")
def health():
    mem = psutil.virtual_memory()
    cpu = psutil.cpu_percent()
    return jsonify({
        "status": "ok",
        "memory": dict(mem._asdict()),
        "cpu_percent": cpu
    })
