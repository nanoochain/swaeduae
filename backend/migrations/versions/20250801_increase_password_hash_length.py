from alembic import op
import sqlalchemy as sa

# revision identifiers, used by Alembic.
revision = '20250801_increase_password_hash_length'
down_revision = None  # Replace with your last migration ID if you have one
branch_labels = None
depends_on = None

def upgrade():
    op.alter_column('users', 'password_hash',
                    existing_type=sa.String(length=128),
                    type_=sa.String(length=512),
                    existing_nullable=False)

def downgrade():
    op.alter_column('users', 'password_hash',
                    existing_type=sa.String(length=512),
                    type_=sa.String(length=128),
                    existing_nullable=False)
