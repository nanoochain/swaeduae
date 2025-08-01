from flask import Blueprint, send_file, request, jsonify
import os, shutil

db_backup_bp = Blueprint('db_backup', __name__)
DB_PATH = "/opt/swaeduae/backend/sawaeduae.db"

@db_backup_bp.route("/api/db/backup", methods=["GET"])
def backup():
    backup_file = "/opt/swaeduae/backups/db_backup.sqlite3"
    shutil.copy(DB_PATH, backup_file)
    return send_file(backup_file, as_attachment=True)

@db_backup_bp.route("/api/db/restore", methods=["POST"])
def restore():
    file = request.files['file']
    file.save(DB_PATH)
    return jsonify({"success": True})
