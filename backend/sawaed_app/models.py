from sawaed_app import db

class User(db.Model):
    id = db.Column(db.Integer, primary_key=True)
    email = db.Column(db.String(120), unique=True, nullable=False)
    username = db.Column(db.String(80), nullable=False)
    password = db.Column(db.String(128), nullable=False)
    role = db.Column(db.String(20), default='user')

class Event(db.Model):
    id = db.Column(db.Integer, primary_key=True)
    title = db.Column(db.String(100), nullable=False)
    date = db.Column(db.DateTime)
    description = db.Column(db.Text)


class VolunteerEvent(db.Model):
    id = db.Column(db.Integer, primary_key=True)
    title = db.Column(db.String(120), nullable=False)
    description = db.Column(db.Text)
    date = db.Column(db.String(100))

class Certificate(db.Model):
    id = db.Column(db.Integer, primary_key=True)
    user_id = db.Column(db.Integer, nullable=False)
    event_id = db.Column(db.Integer, nullable=False)
    issued_at = db.Column(db.DateTime, server_default=db.func.now())

from datetime import datetime

class DeliveryLog(db.Model):
    id = db.Column(db.Integer, primary_key=True)
    certificate_id = db.Column(db.Integer, db.ForeignKey('certificate.id'), nullable=False)
    method = db.Column(db.String(10))  # 'email' or 'whatsapp'
    status = db.Column(db.String(20))  # 'sent', 'pending', 'failed'
    timestamp = db.Column(db.DateTime, default=datetime.utcnow)

Certificate.delivery_status = db.Column(db.String(20), default='pending')  # pending, sent, failed

from datetime import datetime

class DeliveryLog(db.Model):
    id = db.Column(db.Integer, primary_key=True)
    certificate_id = db.Column(db.Integer, db.ForeignKey('certificate.id'), nullable=False)
    method = db.Column(db.String(10))  # 'email' or 'whatsapp'
    status = db.Column(db.String(20))  # 'sent', 'pending', 'failed'
    timestamp = db.Column(db.DateTime, default=datetime.utcnow)

Certificate.delivery_status = db.Column(db.String(20), default='pending')  # pending, sent, failed
