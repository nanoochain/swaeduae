from flask_sqlalchemy import SQLAlchemy
from flask_jwt_extended import JWTManager

try:
    from flask_mail import Mail
except ImportError:
    Mail = None

try:
    from flask_migrate import Migrate
except ImportError:
    Migrate = None

db = SQLAlchemy()
jwt = JWTManager()
mail = Mail() if Mail else None
migrate = Migrate() if Migrate else None
