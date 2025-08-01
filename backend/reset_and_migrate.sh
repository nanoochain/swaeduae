#!/bin/bash

cd /opt/swaeduae/backend

echo "Removing old database and migrations..."
rm -f instance/sawaeduae.db
rm -rf migrations

echo "Setting FLASK_APP environment variable..."
export FLASK_APP=wsgi.py

echo "Initializing migrations..."
flask db init

echo "Creating initial migration for all phases..."
flask db migrate -m "Initial migration for all phases"

echo "Upgrading database..."
flask db upgrade

echo "Migration complete."
