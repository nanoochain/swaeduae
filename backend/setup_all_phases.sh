#!/bin/bash

# Navigate to backend folder
cd /opt/swaeduae/backend

echo "Cleaning old database and migrations..."
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

echo "Backend migration complete."

# --- Backend files updates ---

cat << 'BACKEND_INIT' > sawaed_app/__init__.py
from flask import Flask
from flask_cors import CORS
from flask_sqlalchemy import SQLAlchemy
from flask_jwt_extended import JWTManager
from flask_migrate import Migrate
from .models import db
from .routes.volunteer_hours_routes import volunteer_hours_bp
from .routes.whistleblow_routes import whistleblow_bp
from .routes.org_admin_routes import org_admin_bp
from .routes.event_routes import event_bp
from .routes.admin_routes import admin_bp
from .routes.admin_event import admin_event_bp
from .routes.admin_users import admin_users_bp

def create_app():
    app = Flask(__name__)
    app.config.from_object('sawaed_app.config')
    db.init_app(app)
    JWTManager(app)
    CORS(app)
    Migrate(app, db)
    
    # Register Blueprints
    app.register_blueprint(volunteer_hours_bp)
    app.register_blueprint(whistleblow_bp)
    app.register_blueprint(org_admin_bp)
    app.register_blueprint(event_bp)
    app.register_blueprint(admin_bp)
    app.register_blueprint(admin_event_bp)
    app.register_blueprint(admin_users_bp)

    return app
BACKEND_INIT

echo "Backend __init__.py updated."

# Add or update other backend files similarly here (models.py, routes/*, etc.)
# For brevity, these should be added similarly as separate cat << EOF blocks or synced via git.

echo "Building frontend..."

cd /opt/swaeduae/frontend

npm install

npm run build

echo "Copying frontend build to web server directory..."

sudo cp -r dist/* /var/www/swaeduae.ae/html/

sudo systemctl reload nginx

echo "Frontend deployed."

echo "All phases installed and deployed successfully."

