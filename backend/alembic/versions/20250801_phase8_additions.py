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
