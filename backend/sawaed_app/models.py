from sawaed_app import db
from datetime import datetime

class User(db.Model):
    id = db.Column(db.Integer, primary_key=True)
    username = db.Column(db.String(120), unique=True, nullable=False)
    email = db.Column(db.String(120), unique=True, nullable=False)
    password = db.Column(db.String(200), nullable=False)
    role = db.Column(db.String(20), default='volunteer')

class Event(db.Model):
    id = db.Column(db.Integer, primary_key=True)
    title = db.Column(db.String(200))
    date = db.Column(db.Date)
    description = db.Column(db.Text)
    location = db.Column(db.String(200))

class Certificate(db.Model):
    id = db.Column(db.Integer, primary_key=True)
    user_id = db.Column(db.Integer, db.ForeignKey('user.id'))
    event_id = db.Column(db.Integer, db.ForeignKey('event.id'))
    issued_at = db.Column(db.DateTime, default=datetime.utcnow)
    cert_url = db.Column(db.String(300))

class KYCSubmission(db.Model):
    id = db.Column(db.Integer, primary_key=True)
    user_id = db.Column(db.Integer, db.ForeignKey('user.id'))
    document_url = db.Column(db.String(300))
    status = db.Column(db.String(20), default='pending')

class DeliveryLog(db.Model):
    id = db.Column(db.Integer, primary_key=True)
    cert_id = db.Column(db.Integer, db.ForeignKey('certificate.id'))
    user_id = db.Column(db.Integer, db.ForeignKey('user.id'))
    delivered_via = db.Column(db.String(32))
    status = db.Column(db.String(32))
    timestamp = db.Column(db.DateTime, default=datetime.utcnow)

    # Relationships
    certificate = db.relationship('Certificate', backref='delivery_logs')
    user = db.relationship('User')

class EventVolunteer(db.Model):
    id = db.Column(db.Integer, primary_key=True)
    event_id = db.Column(db.Integer, db.ForeignKey('event.id'))
    user_id = db.Column(db.Integer, db.ForeignKey('user.id'))
    status = db.Column(db.String(20), default='pending')  # approved, rejected, pending
    registered_at = db.Column(db.DateTime, default=datetime.utcnow)
