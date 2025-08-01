import os
import shutil
from flask import Blueprint, jsonify, send_file
from datetime import datetime

admin_bp = Blueprint('admin', __name__)

LOG_FILE_PATH = '/opt/swaeduae/logs/app.log'
BACKUP_SRC = '/opt/swaeduae/backend/sawaeduae.db'
BACKUP_DIR = '/opt/swaeduae/backups'

@admin_bp.route('/admin/logs')
def get_logs():
    if not os.path.exists(LOG_FILE_PATH):
        return jsonify({'error': 'Log file not found'}), 404
    return send_file(LOG_FILE_PATH, as_attachment=True)

@admin_bp.route('/admin/backup')
def download_backup():
    if not os.path.exists(BACKUP_SRC):
        return jsonify({'error': 'Database file not found'}), 404

    os.makedirs(BACKUP_DIR, exist_ok=True)
    timestamp = datetime.now().strftime('%Y-%m-%d_%H-%M-%S')
    backup_path = os.path.join(BACKUP_DIR, f'db_auto_{timestamp}.sqlite3')
    shutil.copy2(BACKUP_SRC, backup_path)

    return send_file(backup_path, as_attachment=True)
