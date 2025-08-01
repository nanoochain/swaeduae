from flask import Flask
from flask_sqlalchemy import SQLAlchemy
from flask_migrate import Migrate
from flask_cors import CORS
from flask_mail import Mail

db = SQLAlchemy()
migrate = Migrate()
mail = Mail()

def create_app():
    app = Flask(__name__)
    app.config.from_object('sawaed_app.config.Config')

    db.init_app(app)
    migrate.init_app(app, db)
    mail.init_app(app)

    CORS(app, origins=[
        "http://localhost:5173",
        "http://139.59.77.83:5173",
        "https://swaeduae.ae"
    ])

    from .routes.auth import auth_bp
    app.register_blueprint(auth_bp, url_prefix='/auth')

    from .routes.events import events_bp
    app.register_blueprint(events_bp, url_prefix='/events')

    from .routes.certificates import cert_bp
    app.register_blueprint(cert_bp, url_prefix='/certificates')

    return app
