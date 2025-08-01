#!/bin/bash

echo "Bringing down existing Docker Compose stack (if any)..."
docker compose down

echo "Building and starting Docker Compose stack in detached mode..."
docker compose up --build -d

echo "Waiting 10 seconds for containers to settle..."
sleep 10

echo "Running database migrations inside backend container..."
docker compose exec backend-web flask db migrate -m "Initial migration for Phase 1"
docker compose exec backend-web flask db upgrade

echo "Restarting Docker Compose stack to apply changes..."
docker compose down
docker compose up -d

echo "Phase 1 deployment completed successfully."
