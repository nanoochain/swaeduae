from flask import Flask
from .config import Config
from .extensions import db
from flask_migrate import Migrate
from .routes.logs import logs_bp
# (Import all other blueprints as needed)

import logging
from logging.handlers import RotatingFileHandler
import os

def create_app():
    app = Flask(__name__)
    app.config.from_object(Config)

    db.init_app(app)
    migrate = Migrate(app, db)

    # Logging: Rotating file handler at /opt/swaeduae/backend/logs/app.log
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
    app.register_blueprint(logs_bp)
    # app.register_blueprint(admin_stats_bp)
    # app.register_blueprint(payment_bp)
    # ...register others as needed

    return app
