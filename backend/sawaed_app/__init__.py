"""
Application factory for the SawaedUAE volunteer platform.

This module exposes a ``create_app`` function which configures a Flask
application, initializes all extensions, registers blueprints, and
applies optional integrations such as metrics and payment providers.

Using an application factory allows for flexible configuration via
environment variables and facilitates testing.
"""

from __future__ import annotations

import os
from flask import Flask, jsonify
from dotenv import load_dotenv

from .extensions import db, jwt, mail, migrate, metrics as _metrics
from prometheus_flask_exporter import PrometheusMetrics
from .socketio import init_socketio  # if not already imported

def create_app() -> Flask:
    """Create and configure a Flask application instance."""

    load_dotenv(os.getenv("ENV_FILE", ".env"), override=False)

    app = Flask(__name__)

    # Core configuration
    app.config["SQLALCHEMY_DATABASE_URI"] = os.getenv("DATABASE_URL", "sqlite:///db.sqlite3")
    app.config["SQLALCHEMY_TRACK_MODIFICATIONS"] = False
    app.config["JWT_SECRET_KEY"] = os.getenv("JWT_SECRET_KEY", "change-me")

    # Mail configuration
    app.config["MAIL_SERVER"] = os.getenv("MAIL_SERVER", "smtp.gmail.com")
    app.config["MAIL_PORT"] = int(os.getenv("MAIL_PORT", 587))
    app.config["MAIL_USE_TLS"] = os.getenv("MAIL_USE_TLS", "true").lower() == "true"
    app.config["MAIL_USERNAME"] = os.getenv("MAIL_USERNAME")
    app.config["MAIL_PASSWORD"] = os.getenv("MAIL_PASSWORD")
    app.config["MAIL_DEFAULT_SENDER"] = os.getenv("MAIL_DEFAULT_SENDER")

    # Initialise extensions
    db.init_app(app)
    jwt.init_app(app)
    mail.init_app(app)
    migrate.init_app(app, db)
    init_socketio(app)

    # Prometheus metrics
    global _metrics
    _metrics = PrometheusMetrics(app)

    # Optional Stripe integration
    stripe_secret = os.getenv("STRIPE_SECRET_KEY")
    if stripe_secret:
        try:
            import stripe
            stripe.api_key = stripe_secret
        except ImportError:
            pass

    # Register blueprints
    from .routes.auth_routes import auth_bp
    app.register_blueprint(auth_bp, url_prefix="/api/auth")

    from .routes.notification_routes import notification_bp
    app.register_blueprint(notification_bp, url_prefix="/api/notify")

    from .routes.payment_routes import payment_bp
    app.register_blueprint(payment_bp, url_prefix="/api/payments")

    from .routes.uaepass_routes import uaepass_bp
    app.register_blueprint(uaepass_bp, url_prefix="/api/uaepass")

    # ✅ NEW: Events and Certificates routes
    from .routes.event_routes import events_bp
    app.register_blueprint(events_bp, url_prefix="/api/events")

    from .routes.certificate_routes import certificates_bp
    app.register_blueprint(certificates_bp, url_prefix="/api/certificates")

    # Root health check
    @app.get("/")
    def index() -> tuple[dict[str, str], int]:
        return {"status": "ok"}, 200

    # Generic error handler
    @app.errorhandler(Exception)
    def handle_exception(e: Exception):
        return jsonify({"error": str(e)}), 500

    return app
