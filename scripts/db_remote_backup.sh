#!/bin/bash
set -e
BACKUP_DIR=/opt/swaeduae/backups/\$(date +%F)
mkdir -p \$BACKUP_DIR
cp /opt/swaeduae/backend/sawaeduae.db \$BACKUP_DIR/
rsync -avz \$BACKUP_DIR/ backup@backupserver:/backups/swaeduae/
echo "Remote backup done at \$BACKUP_DIR"
