import os
import shutil
from datetime import datetime

SRC_DB = '/opt/swaeduae/backend/sawaeduae.db'
DEST_DIR = '/opt/swaeduae/backups'

def auto_backup():
    if os.path.exists(SRC_DB):
        os.makedirs(DEST_DIR, exist_ok=True)
        timestamp = datetime.now().strftime('%Y-%m-%d_%H-%M-%S')
        backup_file = os.path.join(DEST_DIR, f'db_cron_{timestamp}.sqlite3')
        shutil.copy2(SRC_DB, backup_file)

if __name__ == "__main__":
    auto_backup()
