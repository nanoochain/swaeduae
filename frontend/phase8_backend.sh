#!/bin/bash
# SawaedUAE Backend Phase 8: Volunteer Hours, Badges, Whistleblow, Org Admin APIs

cd /opt/swaeduae/backend

# Overwrite models.py with all needed models
cat > sawaed_app/models.py <<'EOF'
from flask_sqlalchemy import SQLAlchemy
from datetime import datetime

db = SQLAlchemy()

class User(db.Model):
    id = db.Column(db.Integer, primary_key=True)
    username = db.Column(db.String(120), nullable=False)
    email = db.Column(db.String(120), unique=True, nullable=False)
    password = db.Column(db.String(128), nullable=False)
    role = db.Column(db.String(32), default='volunteer')  # volunteer, org_admin, admin
    org_id = db.Column(db.Integer, db.ForeignKey('organization.id'), nullable=True)
    created_at = db.Column(db.DateTime, default=datetime.utcnow)
    # ... add other user fields as needed

class Organization(db.Model):
    id = db.Column(db.Integer, primary_key=True)
    name = db.Column(db.String(128), nullable=False)
    users = db.relationship('User', backref='organization', lazy=True)
    events = db.relationship('Event', backref='organization', lazy=True)

class Event(db.Model):
    id = db.Column(db.Integer, primary_key=True)
    name = db.Column(db.String(128), nullable=False)
    description = db.Column(db.Text)
    org_id = db.Column(db.Integer, db.ForeignKey('organization.id'), nullable=False)
    start_date = db.Column(db.DateTime)
    end_date = db.Column(db.DateTime)
    volunteers = db.relationship('EventVolunteer', backref='event', lazy=True)

class EventVolunteer(db.Model):
    id = db.Column(db.Integer, primary_key=True)
    user_id = db.Column(db.Integer, db.ForeignKey('user.id'))
    event_id = db.Column(db.Integer, db.ForeignKey('event.id'))
    approved = db.Column(db.Boolean, default=False)
    applied_at = db.Column(db.DateTime, default=datetime.utcnow)

# --- Phase 8: New models ---

class VolunteerHour(db.Model):
    id = db.Column(db.Integer, primary_key=True)
    user_id = db.Column(db.Integer, db.ForeignKey('user.id'))
    event = db.Column(db.String(120))
    hours = db.Column(db.Float)
    date = db.Column(db.DateTime, default=datetime.utcnow)

class VolunteerBadge(db.Model):
    id = db.Column(db.Integer, primary_key=True)
    user_id = db.Column(db.Integer, db.ForeignKey('user.id'))
    badge_name = db.Column(db.String(64))
    awarded_at = db.Column(db.DateTime, default=datetime.utcnow)

class Whistleblow(db.Model):
    id = db.Column(db.Integer, primary_key=True)
    user_id = db.Column(db.Integer, db.ForeignKey('user.id'), nullable=True)
    text = db.Column(db.Text, nullable=False)
    submitted_at = db.Column(db.DateTime, default=datetime.utcnow)
    reviewed = db.Column(db.Boolean, default=False)
    reviewed_by = db.Column(db.Integer, db.ForeignKey('user.id'), nullable=True)
    reviewed_at = db.Column(db.DateTime, nullable=True)
    status = db.Column(db.String(32), default='pending')  # pending, reviewed, resolved

class OrgApplicant(db.Model):
    id = db.Column(db.Integer, primary_key=True)
    user_id = db.Column(db.Integer, db.ForeignKey('user.id'))
    org_id = db.Column(db.Integer, db.ForeignKey('organization.id'))
    event_id = db.Column(db.Integer, db.ForeignKey('event.id'))
    status = db.Column(db.String(32), default='pending')  # pending, approved, rejected
    applied_at = db.Column(db.DateTime, default=datetime.utcnow)

# --- END Phase 8 models ---
EOF

# Volunteer Hours & Badges API routes
cat > sawaed_app/routes/volunteer_hours_routes.py <<'EOF'
from flask import Blueprint, request, jsonify
from ..models import db, VolunteerHour, VolunteerBadge, User
from flask_jwt_extended import jwt_required, get_jwt_identity
from datetime import datetime

volunteer_hours_bp = Blueprint('volunteer_hours_bp', __name__)

@volunteer_hours_bp.route("/volunteer/<int:user_id>/hours", methods=["GET"])
@jwt_required()
def get_volunteer_hours(user_id):
    logs = VolunteerHour.query.filter_by(user_id=user_id).order_by(VolunteerHour.date.desc()).all()
    total = sum([h.hours for h in logs])
    return jsonify({
        "logs": [
            {
                "event": h.event,
                "hours": h.hours,
                "date": h.date.strftime('%Y-%m-%d')
            } for h in logs
        ],
        "total": total
    })

@volunteer_hours_bp.route("/volunteer/<int:user_id>/hours", methods=["POST"])
@jwt_required()
def log_volunteer_hours(user_id):
    data = request.json
    hours = float(data.get('hours', 0))
    event = data.get('event', 'Other')
    if not hours or not event:
        return jsonify({"error": "Missing fields"}), 400
    entry = VolunteerHour(user_id=user_id, hours=hours, event=event)
    db.session.add(entry)
    db.session.commit()
    # Optional: Assign badges here (see below)
    return jsonify({"message": "Hours logged!"})

# Badges endpoint
BADGE_THRESHOLDS = [
    (100, "Platinum Service"),
    (50, "Gold Volunteer"),
    (25, "Silver Contributor"),
    (10, "Bronze Helper"),
]

@volunteer_hours_bp.route("/volunteer/<int:user_id>/badges", methods=["GET"])
@jwt_required()
def get_badges(user_id):
    total_hours = db.session.query(db.func.sum(VolunteerHour.hours)).filter_by(user_id=user_id).scalar() or 0
    badges = []
    for thresh, name in BADGE_THRESHOLDS:
        if total_hours >= thresh:
            badges.append(name)
            # Optionally: Award badge in DB
            if not VolunteerBadge.query.filter_by(user_id=user_id, badge_name=name).first():
                db.session.add(VolunteerBadge(user_id=user_id, badge_name=name))
    db.session.commit()
    return jsonify({"badges": badges, "total_hours": total_hours})
EOF

# Whistleblow API routes
cat > sawaed_app/routes/whistleblow_routes.py <<'EOF'
from flask import Blueprint, request, jsonify
from ..models import db, Whistleblow, User
from flask_jwt_extended import jwt_required, get_jwt_identity
from datetime import datetime

whistleblow_bp = Blueprint('whistleblow_bp', __name__)

@whistleblow_bp.route("/whistleblow", methods=["POST"])
@jwt_required()
def submit_whistleblow():
    user_id = get_jwt_identity()
    text = request.json.get("text")
    if not text:
        return jsonify({"error": "Text required"}), 400
    w = Whistleblow(user_id=user_id, text=text)
    db.session.add(w)
    db.session.commit()
    return jsonify({"message": "Whistleblowing report submitted"})

@whistleblow_bp.route("/admin/whistleblow", methods=["GET"])
@jwt_required()
def get_all_whistleblows():
    # Only admins
    admin = User.query.get(get_jwt_identity())
    if admin.role not in ("admin", "org_admin"):
        return jsonify({"error": "Unauthorized"}), 403
    items = Whistleblow.query.order_by(Whistleblow.submitted_at.desc()).all()
    return jsonify([{
        "id": w.id,
        "user_id": w.user_id,
        "text": w.text,
        "submitted_at": w.submitted_at.strftime('%Y-%m-%d %H:%M'),
        "reviewed": w.reviewed,
        "status": w.status
    } for w in items])
EOF

# Org Admin Portal (Applicant management)
cat > sawaed_app/routes/org_admin_routes.py <<'EOF'
from flask import Blueprint, request, jsonify
from ..models import db, OrgApplicant, User, Event, Organization
from flask_jwt_extended import jwt_required, get_jwt_identity

org_admin_bp = Blueprint('org_admin_bp', __name__)

@org_admin_bp.route("/org/<int:org_id>/applicants", methods=["GET"])
@jwt_required()
def get_org_applicants(org_id):
    current_user = User.query.get(get_jwt_identity())
    if current_user.role not in ("org_admin", "admin") or (current_user.org_id != org_id and current_user.role != "admin"):
        return jsonify({"error": "Unauthorized"}), 403
    applicants = OrgApplicant.query.filter_by(org_id=org_id, status="pending").all()
    return jsonify({"applicants": [
        {
            "id": a.id,
            "user_id": a.user_id,
            "event": Event.query.get(a.event_id).name if a.event_id else None,
            "name": User.query.get(a.user_id).username if a.user_id else "",
            "email": User.query.get(a.user_id).email if a.user_id else "",
            "applied_at": a.applied_at.strftime('%Y-%m-%d')
        }
        for a in applicants
    ]})

@org_admin_bp.route("/org/applicant/<int:app_id>/approve", methods=["POST"])
@jwt_required()
def approve_applicant(app_id):
    app = OrgApplicant.query.get(app_id)
    if not app:
        return jsonify({"error": "Applicant not found"}), 404
    app.status = "approved"
    db.session.commit()
    return jsonify({"message": "Applicant approved"})

@org_admin_bp.route("/org/applicant/<int:app_id>/reject", methods=["POST"])
@jwt_required()
def reject_applicant(app_id):
    app = OrgApplicant.query.get(app_id)
    if not app:
        return jsonify({"error": "Applicant not found"}), 404
    app.status = "rejected"
    db.session.commit()
    return jsonify({"message": "Applicant rejected"})
EOF

# Register Blueprints in __init__.py
cat > sawaed_app/__init__.py <<'EOF'
from flask import Flask
from flask_cors import CORS
from flask_sqlalchemy import SQLAlchemy
from flask_jwt_extended import JWTManager
from .models import db
from .routes.volunteer_hours_routes import volunteer_hours_bp
from .routes.whistleblow_routes import whistleblow_bp
from .routes.org_admin_routes import org_admin_bp

def create_app():
    app = Flask(__name__)
    app.config.from_object('sawaed_app.config')
    db.init_app(app)
    JWTManager(app)
    CORS(app)
    # Register Phase 8 APIs
    app.register_blueprint(volunteer_hours_bp)
    app.register_blueprint(whistleblow_bp)
    app.register_blueprint(org_admin_bp)
    # Register other routes as needed...
    return app
EOF

# --- Sample Alembic migration for new tables (optional) ---
mkdir -p alembic/versions
cat > alembic/versions/20250801_phase8_additions.py <<'EOF'
"""phase 8 additions: volunteer hour, badge, whistleblow, org applicant

Revision ID: phase8_additions
Revises: 
Create Date: 2025-08-01

"""
from alembic import op
import sqlalchemy as sa

revision = 'phase8_additions'
down_revision = None
branch_labels = None
depends_on = None

def upgrade():
    op.create_table('volunteer_hour',
        sa.Column('id', sa.Integer(), nullable=False),
        sa.Column('user_id', sa.Integer(), nullable=True),
        sa.Column('event', sa.String(length=120), nullable=True),
        sa.Column('hours', sa.Float(), nullable=True),
        sa.Column('date', sa.DateTime(), nullable=True),
        sa.PrimaryKeyConstraint('id')
    )
    op.create_table('volunteer_badge',
        sa.Column('id', sa.Integer(), nullable=False),
        sa.Column('user_id', sa.Integer(), nullable=True),
        sa.Column('badge_name', sa.String(length=64), nullable=True),
        sa.Column('awarded_at', sa.DateTime(), nullable=True),
        sa.PrimaryKeyConstraint('id')
    )
    op.create_table('whistleblow',
        sa.Column('id', sa.Integer(), nullable=False),
        sa.Column('user_id', sa.Integer(), nullable=True),
        sa.Column('text', sa.Text(), nullable=False),
        sa.Column('submitted_at', sa.DateTime(), nullable=True),
        sa.Column('reviewed', sa.Boolean(), nullable=True),
        sa.Column('reviewed_by', sa.Integer(), nullable=True),
        sa.Column('reviewed_at', sa.DateTime(), nullable=True),
        sa.Column('status', sa.String(length=32), nullable=True),
        sa.PrimaryKeyConstraint('id')
    )
    op.create_table('org_applicant',
        sa.Column('id', sa.Integer(), nullable=False),
        sa.Column('user_id', sa.Integer(), nullable=True),
        sa.Column('org_id', sa.Integer(), nullable=True),
        sa.Column('event_id', sa.Integer(), nullable=True),
        sa.Column('status', sa.String(length=32), nullable=True),
        sa.Column('applied_at', sa.DateTime(), nullable=True),
        sa.PrimaryKeyConstraint('id')
    )

def downgrade():
    op.drop_table('org_applicant')
    op.drop_table('whistleblow')
    op.drop_table('volunteer_badge')
    op.drop_table('volunteer_hour')
EOF

echo "✅ Phase 8 backend API and models written!"
echo "Next steps:"
echo "1. Run Alembic migration or 'flask db upgrade' to update your DB schema."
echo "2. Restart your backend server."
echo "3. Test new API endpoints!"
