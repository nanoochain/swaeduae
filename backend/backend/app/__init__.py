# /opt/swaeduae/backend/app/__init__.py

from flask import Flask
from flask_sqlalchemy import SQLAlchemy

db = SQLAlchemy()

def create_app():
    app = Flask(__name__)
    app.config.from_object("config.Config")

    db.init_app(app)

    # Import and register routes
    from app.routes.auth_routes import auth_bp
    from app.routes.volunteer_routes import volunteer_bp
    from app.routes.admin_routes import admin_bp

    app.register_blueprint(auth_bp, url_prefix="/auth")
    app.register_blueprint(volunteer_bp, url_prefix="/volunteer")
    app.register_blueprint(admin_bp, url_prefix="/admin")

    return app
