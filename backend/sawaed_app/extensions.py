"""
Centralized extensions used throughout the SawaedUAE backend.

This module instantiates objects for SQLAlchemy, JWT handling, mail,
database migrations, and metrics collection. Import these objects
wherever they are needed and initialize them in your application
factory.
"""

from flask_sqlalchemy import SQLAlchemy
from flask_jwt_extended import JWTManager
from flask_mail import Mail
from flask_migrate import Migrate

# SQLAlchemy instance for ORM operations
db = SQLAlchemy()

# JWT manager for authentication
jwt = JWTManager()

# Mail extension for email notifications
mail = Mail()

# Database migration manager
migrate = Migrate()

# Prometheus metrics exporter; instantiated in the app factory
from prometheus_flask_exporter import PrometheusMetrics

# Metrics exporter is created in the application factory.  See
# ``sawaed_app.__init__.py``.  The annotation below is only for
# type checking; the variable is assigned in ``create_app``.
metrics: PrometheusMetrics | None = None