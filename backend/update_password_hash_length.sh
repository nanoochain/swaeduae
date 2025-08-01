#!/bin/bash
echo "Starting containers..."
docker compose up -d web db

echo "Running migration..."
docker compose exec web flask db migrate -m "Increase password_hash length to 512"

echo "Upgrading database..."
docker compose exec web flask db upgrade

echo "Restarting web container..."
docker compose restart web

echo "Done."
