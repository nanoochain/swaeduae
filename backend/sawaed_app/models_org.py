from .extensions import db

class Organization(db.Model):
    id = db.Column(db.Integer, primary_key=True)
    name = db.Column(db.String(120), unique=True, nullable=False)
    domain = db.Column(db.String(120), unique=True)
    admin_user_id = db.Column(db.Integer, db.ForeignKey("user.id"))

class UserOrg(db.Model):
    id = db.Column(db.Integer, primary_key=True)
    user_id = db.Column(db.Integer, db.ForeignKey("user.id"))
    org_id = db.Column(db.Integer, db.ForeignKey("organization.id"))
