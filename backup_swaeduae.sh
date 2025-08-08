#!/usr/bin/env bash
set -euo pipefail

# === Fixed MySQL credentials from cPanel ===
# If you later change them, edit here. These override .env (but you can disable by setting USE_DOTENV_ONLY=true).
USE_DOTENV_ONLY="${USE_DOTENV_ONLY:-false}"
FIXED_DB_HOST="${FIXED_DB_HOST:-localhost}"
FIXED_DB_PORT="${FIXED_DB_PORT:-3306}"
FIXED_DB_USER="${FIXED_DB_USER:-vminingc_admin}"
FIXED_DB_NAME="${FIXED_DB_NAME:-vminingc_swaeduae_db}"
FIXED_DB_PASS="${FIXED_DB_PASS:-vW%nTZhFOq(N}"

PROJECT_DIR="$(pwd)"
PROJECT_NAME="${PROJECT_DIR##*/}"
BACKUP_DIR="$HOME/swaed_backups"
TS="$(date +'%Y%m%d_%H%M%S')"
ARCHIVE_NAME="${PROJECT_NAME}_${TS}.tar.gz"
SQL_NAME="${PROJECT_NAME}_${TS}.sql"
CHECKSUM_NAME="${ARCHIVE_NAME}.sha256"

mkdir -p "$BACKUP_DIR"

# --- Helpers ---
read_env () {
  local key="$1" env_file="$2"
  awk -F '=' -v k="$key" '
    $0 ~ "^[[:space:]]*"k"[[:space:]]*=" && $0 !~ /^[[:space:]]*#/ {val=$0}
    END{
      sub(/^[^=]*=/,"",val);
      gsub(/^[[:space:]]+|[[:space:]]+$/,"",val);
      gsub(/^"|"$/, "", val);
      gsub(/^'"'"'|'"'"'$/, "", val);
      print val
    }' "$env_file"
}

# --- Decide credential source ---
ENV_FILE="$PROJECT_DIR/.env"
if [[ "$USE_DOTENV_ONLY" == "true" && -f "$ENV_FILE" ]]; then
  echo "==> Using .env only for DB credentials"
  DB_HOST="$(read_env DB_HOST "$ENV_FILE")"
  DB_PORT="$(read_env DB_PORT "$ENV_FILE")"; DB_PORT="${DB_PORT:-3306}"
  DB_DATABASE="$(read_env DB_DATABASE "$ENV_FILE")"
  DB_USERNAME="$(read_env DB_USERNAME "$ENV_FILE")"
  DB_PASSWORD="$(read_env DB_PASSWORD "$ENV_FILE")"
else
  echo "==> Using fixed cPanel DB credentials (override .env)"
  DB_HOST="$FIXED_DB_HOST"
  DB_PORT="$FIXED_DB_PORT"
  DB_DATABASE="$FIXED_DB_NAME"
  DB_USERNAME="$FIXED_DB_USER"
  DB_PASSWORD="$FIXED_DB_PASS"
fi

# --- DB dump ---
echo "==> Dumping database '$DB_DATABASE'..."
# Use MYSQL_PWD to avoid shell escaping issues & not echo password
MYSQL_PWD="$DB_PASSWORD" mysqldump \
  --host="$DB_HOST" --port="$DB_PORT" \
  --user="$DB_USERNAME" --databases "$DB_DATABASE" \
  --single-transaction --routines --events --triggers \
  --default-character-set=utf8mb4 \
  > "$BACKUP_DIR/$SQL_NAME"

# --- Project archive ---
echo "==> Creating project archive..."
tar --exclude='./node_modules' \
    --exclude='./vendor' \
    --exclude='./storage/framework/cache/*' \
    --exclude='./storage/framework/sessions/*' \
    --exclude='./storage/framework/views/*' \
    --exclude='./storage/logs/*' \
    --exclude='./.git' \
    --exclude='./.DS_Store' \
    --exclude='./backup_swaeduae.sh' \
    --exclude="$BACKUP_DIR" \
    -czf "$BACKUP_DIR/$ARCHIVE_NAME" \
    -C "$PROJECT_DIR/.." "$PROJECT_NAME" \
    -C "$BACKUP_DIR" "$SQL_NAME"

# --- Verify/checksum & rotation ---
echo "==> Writing checksum..."
( cd "$BACKUP_DIR" && sha256sum "$ARCHIVE_NAME" > "$CHECKSUM_NAME" )

echo "==> Cleaning temp SQL (included in archive)..."
rm -f "$BACKUP_DIR/$SQL_NAME"

echo "==> Rotate old backups (older than 14 days)..."
find "$BACKUP_DIR" -type f -name "${PROJECT_NAME}_*.tar.gz" -mtime +14 -delete
find "$BACKUP_DIR" -type f -name "${PROJECT_NAME}_*.tar.gz.sha256" -mtime +14 -delete

echo "==> Backup complete:"
ls -lh "$BACKUP_DIR/$ARCHIVE_NAME" "$BACKUP_DIR/$CHECKSUM_NAME"
echo "Stored in: $BACKUP_DIR"

