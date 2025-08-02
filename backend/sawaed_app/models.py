"""
Database models for the SawaedUAE backend.

These SQLAlchemy models define the core data structures used by the
platform. Feel free to extend them with additional fields and
relationships as your application grows.
"""

from __future__ import annotations

from .extensions import db


class User(db.Model):
    """A user of the platform."""

    id: int = db.Column(db.Integer, primary_key=True)
    username: str = db.Column(db.String(128), unique=True, nullable=False)
    email: str = db.Column(db.String(255), unique=True, nullable=False)
    password_hash: str = db.Column(db.String(255), nullable=False)
    role: str = db.Column(db.String(32), nullable=False, default="volunteer")


class VolunteerEvent(db.Model):
    """A volunteer event that users can sign up for."""

    id: int = db.Column(db.Integer, primary_key=True)
    name: str = db.Column(db.String(128), nullable=False)
    description: str = db.Column(db.Text, nullable=True)
    date: str = db.Column(db.String(64), nullable=True)
    location: str = db.Column(db.String(128), nullable=True)


class EventVolunteer(db.Model):
    """Association table linking volunteers to events."""

    id: int = db.Column(db.Integer, primary_key=True)
    event_id: int = db.Column(db.Integer, db.ForeignKey("volunteer_event.id"), nullable=False)
    user_id: int = db.Column(db.Integer, db.ForeignKey("user.id"), nullable=False)


class Payment(db.Model):
    """Record of a payment processed via Stripe."""

    id: int = db.Column(db.Integer, primary_key=True)
    user_id: int = db.Column(db.Integer, db.ForeignKey("user.id"), nullable=False)
    amount: float = db.Column(db.Float, nullable=False)
    currency: str = db.Column(db.String(10), nullable=False, default="aed")
    status: str = db.Column(db.String(32), nullable=False, default="pending")
    stripe_session_id: str = db.Column(db.String(255), nullable=False)


class Certificate(db.Model):
    """Issued certificate for a user."""

    id: int = db.Column(db.Integer, primary_key=True)
    title: str = db.Column(db.String(128), nullable=False)
    recipient_name: str = db.Column(db.String(128), nullable=False)
    issue_date: str = db.Column(db.String(64), nullable=True)

    user_id: int = db.Column(db.Integer, db.ForeignKey("user.id"))
    user = db.relationship("User", backref="certificates")
