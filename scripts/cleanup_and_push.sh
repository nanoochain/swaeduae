#!/bin/bash
set -e

echo "Starting cleanup for nanoochain/swaeduae project..."

# Remove old backup files
rm -f /opt/swaeduae/backups/db_auto_2025-07-29_03-41-19.sqlite3
rm -f /opt/swaeduae/backups/db_auto_2025-07-31_21-01-55.sqlite3
rm -f /opt/swaeduae/backups/db_cron_2025-07-31_21-03-39.sqlite3
rm -f /opt/swaeduae/backend/nanoochain_full_updated.tar.gz
rm -f /opt/swaeduae/swaeduae-backup-20250801_0152.zip

# Remove duplicate/old migrations if any
rm -f /opt/swaeduae/backend/migrations/versions/20250801a_increase_password_hash_length.py

# Remove Python backup files
rm -f /opt/swaeduae/backend/sawaed_app/__init__.py.bak
rm -f /opt/swaeduae/backend/sawaed_app/__init__.py.save

# Remove Python caches
find /opt/swaeduae -type d -name "__pycache__" -exec rm -rf {} +
find /opt/swaeduae -type f -name "*.pyc" -exec rm -f {} +

# Remove logs
rm -f /opt/swaeduae/logs/*.log
rm -f /opt/swaeduae/backend/logs/*.log

# Add/update .gitignore file
cat > /opt/swaeduae/.gitignore << 'EOF'
# Backup files
backups/
*.zip
*.tar.gz
*.sqlite3

# Editor backups
*.bak
*.save

# Python caches
__pycache__/
*.pyc

# Logs
logs/
*.log

# Node modules & virtual envs
venv/
node_modules/
EOF

cd /opt/swaeduae

# Remove cached files from git index
git rm -r --cached backups __pycache__ '*.pyc' logs '*.log' '*.bak' '*.save' 2>/dev/null || true

# Add changes and .gitignore
git add .gitignore
git add .

# Commit changes
git commit -m "Cleanup backups, caches, logs; add .gitignore"

echo "Cleanup completed. Now pushing changes to GitHub..."

git push origin main

echo "Push complete. Your repo https://github.com/nanoochain/swaeduae is updated."
