"""phase 8 additions: volunteer hour

Revision ID: phase8_additions
Revises: 0c6ad32efb77
Create Date: 2025-08-01

"""
from alembic import op
import sqlalchemy as sa

revision = 'phase8_additions'
down_revision = '0c6ad32efb77'
branch_labels = None
depends_on = None

def upgrade():
    op.create_table(
        'volunteer_hour',
        sa.Column('id', sa.Integer(), nullable=False),
        sa.Column('user_id', sa.Integer(), sa.ForeignKey('user.id'), nullable=False),
        sa.Column('event_id', sa.Integer(), sa.ForeignKey('event.id'), nullable=False),
        sa.Column('hours', sa.Float(), nullable=False),
        sa.Column('approved', sa.Boolean(), nullable=True, server_default=sa.text('false')),
        sa.PrimaryKeyConstraint('id')
    )

def downgrade():
    op.drop_table('volunteer_hour')
