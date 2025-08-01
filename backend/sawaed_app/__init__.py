from flask import Flask
from flask_sqlalchemy import SQLAlchemy
from flask_migrate import Migrate
from werkzeug.security import generate_password_hash

db = SQLAlchemy()
migrate = Migrate()

def create_app():
    app = Flask(__name__)
    app.config.from_mapping(
        SQLALCHEMY_DATABASE_URI="postgresql://swaeduser:swaedpass@db:5432/swaeddb",
        SQLALCHEMY_TRACK_MODIFICATIONS=False,
        SECRET_KEY="your_super_secret_key",
    )

    db.init_app(app)
    migrate.init_app(app, db)

    from sawaed_app.models import User

    with app.app_context():
        admin = User.query.filter_by(username='admin').first()
        if not admin:
            admin = User(
                username='admin',
                email='admin@swaeduae.ae',
                password_hash=generate_password_hash('changeme'),
                role='admin'
            )
            db.session.add(admin)
            db.session.commit()

    return app
