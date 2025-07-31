#!/bin/bash
TIMESTAMP=$(date +'%Y-%m-%d_%H-%M-%S')
BACKUP_DIR="/opt/swaeduae/backups"
SOURCE_DB="/opt/swaeduae/backend/instance/swaeduae.db"
DEST_DB="$BACKUP_DIR/db_auto_$TIMESTAMP.sqlite3"

mkdir -p "$BACKUP_DIR"
if [ -f "$SOURCE_DB" ]; then
    cp "$SOURCE_DB" "$DEST_DB"
    echo "[$(date)] ✅ Daily auto-backup created: $DEST_DB" >> /opt/swaeduae/deploy.log
else
    echo "[$(date)] ⚠️ DB not found during auto-backup" >> /opt/swaeduae/deploy.log
fi
