#!/bin/bash
set -e
echo "🚀 Starting Phase 5 Optional Deployment Tasks..."

# === 1. Run npm audit fix for frontend ===
cd /opt/swaeduae/frontend
npm audit fix --force

# === 2. GitHub Actions CI/CD Workflow ===
cd /opt/swaeduae/.github/workflows
mkdir -p /opt/swaeduae/.github/workflows
nano deploy.yml << 'EOF'
name: 🚀 Deploy to Server

on:
  push:
    branches: [ main ]

jobs:
  deploy:
    runs-on: ubuntu-latest
    steps:
    - name: Checkout code
      uses: actions/checkout@v3

    - name: Copy files via SCP
      uses: appleboy/scp-action@master
      with:
        host: ${{ secrets.SERVER_HOST }}
        username: ${{ secrets.SERVER_USER }}
        key: ${{ secrets.SERVER_KEY }}
        source: "."
        target: "/opt/swaeduae"

    - name: Restart services
      uses: appleboy/ssh-action@master
      with:
        host: ${{ secrets.SERVER_HOST }}
        username: ${{ secrets.SERVER_USER }}
        key: ${{ secrets.SERVER_KEY }}
        script: |
          cd /opt/swaeduae
          docker-compose down && docker-compose up -d
EOF

# === 3. Flask-SocketIO Integration ===
cd /opt/swaeduae/backend/sawaed_app
nano socketio_server.py << 'EOF'
from flask_socketio import SocketIO
socketio = SocketIO(cors_allowed_origins="*")
EOF

cd /opt/swaeduae/backend
nano app_socket.py << 'EOF'
from sawaed_app import create_app
from sawaed_app.socketio_server import socketio

app = create_app()

if __name__ == "__main__":
    socketio.init_app(app)
    socketio.run(app, host="0.0.0.0", port=5000)
EOF

# === 4. Log Viewer + Backup Route ===
cd /opt/swaeduae/backend/sawaed_app/routes
nano logs_and_backup.py << 'EOF'
from flask import Blueprint, jsonify
import os
from datetime import datetime
from ..models import db

sys_bp = Blueprint('sys', __name__)

@sys_bp.route('/admin/logs', methods=['GET'])
def get_logs():
    with open("/var/log/syslog", "r") as f:
        return jsonify({"logs": f.readlines()[-50:]})

@sys_bp.route('/admin/backup', methods=['GET'])
def backup_db():
    filename = f"/opt/swaeduae/backups/backup_{datetime.now().strftime('%Y%m%d_%H%M')}.sqlite"
    os.system(f"cp /opt/swaeduae/backend/database.db {filename}")
    return jsonify({"status": "Backup complete", "file": filename})
EOF

# === 5. Register Blueprint in __init__.py ===
cd /opt/swaeduae/backend/sawaed_app
sed -i "/register_blueprint(admin_bp)/a \
    from .routes.logs_and_backup import sys_bp\n    app.register_blueprint(sys_bp)" __init__.py

echo "✅ Optional Updates Applied. Ready for production test!"
