from flask import Flask
from flask_sqlalchemy import SQLAlchemy
from flask_cors import CORS
from flask_jwt_extended import JWTManager
import os

db = SQLAlchemy()
jwt = JWTManager()

def create_app():
    app = Flask(__name__)
    CORS(app)

    # Configuration
    basedir = os.path.abspath(os.path.dirname(__file__))
    db_path = os.path.join(os.path.dirname(basedir), 'site.db')
    app.config['SQLALCHEMY_DATABASE_URI'] = f'sqlite:///{db_path}'
    app.config['SQLALCHEMY_TRACK_MODIFICATIONS'] = False
    app.config['JWT_SECRET_KEY'] = 'your-secret-key'

    # Initialize extensions
    db.init_app(app)
    jwt.init_app(app)

    # Import models
    from sawaed_app import models

    # Create database
    with app.app_context():
        db.create_all()

    # Register blueprints
    from sawaed_app.routes.auth_routes import auth_bp
    from sawaed_app.routes.event_routes import event_bp
    from sawaed_app.routes.admin_routes import admin_bp

    app.register_blueprint(auth_bp)
    app.register_blueprint(event_bp)
    app.register_blueprint(admin_bp)

    return app
