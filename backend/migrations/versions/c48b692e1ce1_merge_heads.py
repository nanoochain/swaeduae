"""Merge heads

Revision ID: c48b692e1ce1
Revises: 20250801_increase_password_hash_length, 20250801a
Create Date: 2025-08-01 04:23:31.045974

"""
from alembic import op
import sqlalchemy as sa


# revision identifiers, used by Alembic.
revision = 'c48b692e1ce1'
down_revision = ('20250801_increase_password_hash_length', '20250801a')
branch_labels = None
depends_on = None


def upgrade():
    pass


def downgrade():
    pass
