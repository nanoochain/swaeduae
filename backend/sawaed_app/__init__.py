from flask import Flask
from .config import Config
from .extensions import db, jwt, mail, migrate
from .routes.logs import logs_bp
from .routes.auth_routes import auth_bp
import logging
from logging.handlers import RotatingFileHandler
import os

def create_app():
    app = Flask(__name__)
    app.config.from_object(Config)

    db.init_app(app)

    if migrate is not None:
        migrate.init_app(app, db)

    jwt.init_app(app)

    if mail is not None:
        mail.init_app(app)

    logs_dir = os.path.join(os.path.dirname(os.path.dirname(os.path.abspath(__file__))), "logs")
    if not os.path.exists(logs_dir):
        os.makedirs(logs_dir)
    file_handler = RotatingFileHandler(
        os.path.join(logs_dir, 'app.log'),
        maxBytes=5 * 1024 * 1024,
        backupCount=3
    )
    file_handler.setFormatter(logging.Formatter(
        '[%(asctime)s] %(levelname)s in %(module)s: %(message)s'
    ))
    file_handler.setLevel(logging.INFO)
    app.logger.addHandler(file_handler)
    app.logger.setLevel(logging.INFO)

    # Register blueprints
    app.register_blueprint(auth_bp, url_prefix='/auth')
    app.register_blueprint(logs_bp)
    # Add more blueprints as needed (admin, certificates, kyc, events, etc.)

    return app
