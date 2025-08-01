from .extensions import db

class User(db.Model):
    id = db.Column(db.Integer, primary_key=True)
    username = db.Column(db.String(80), unique=True, nullable=False)
    email = db.Column(db.String(120), unique=True, nullable=False)
    password = db.Column(db.String(200), nullable=False)
    role = db.Column(db.String(20), default="volunteer")
    certificates = db.relationship('Certificate', backref='user', lazy=True)

class Event(db.Model):
    id = db.Column(db.Integer, primary_key=True)
    name = db.Column(db.String(150), nullable=False)
    description = db.Column(db.Text)
    date = db.Column(db.Date)
    location = db.Column(db.String(150))
    volunteer_hours = db.relationship('VolunteerHour', backref='event', lazy=True)

class Certificate(db.Model):
    id = db.Column(db.Integer, primary_key=True)
    user_id = db.Column(db.Integer, db.ForeignKey('user.id'), nullable=False)
    event_id = db.Column(db.Integer, db.ForeignKey('event.id'), nullable=False)
    issued_at = db.Column(db.DateTime)
    url = db.Column(db.String(255))

class VolunteerHour(db.Model):
    id = db.Column(db.Integer, primary_key=True)
    user_id = db.Column(db.Integer, db.ForeignKey('user.id'), nullable=False)
    event_id = db.Column(db.Integer, db.ForeignKey('event.id'), nullable=False)
    hours = db.Column(db.Float, nullable=False)
    approved = db.Column(db.Boolean, default=False)

# Add other models as needed (Organization, APIKey, Webhook, etc)
