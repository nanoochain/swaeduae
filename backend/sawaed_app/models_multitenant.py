from .extensions import db

class Tenant(db.Model):
    id = db.Column(db.Integer, primary_key=True)
    name = db.Column(db.String(128), nullable=False)
    domain = db.Column(db.String(128), nullable=True, unique=True)

class UserTenant(db.Model):
    id = db.Column(db.Integer, primary_key=True)
    user_id = db.Column(db.Integer, db.ForeignKey("user.id"))
    tenant_id = db.Column(db.Integer, db.ForeignKey("tenant.id"))
