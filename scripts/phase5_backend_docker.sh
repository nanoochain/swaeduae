#!/bin/bash
echo "🐘 Starting Phase 5: Backend Docker + PostgreSQL Setup..."

# 1. Create Dockerfile
echo "🛠 Creating Dockerfile..."
cat << 'EOT' > backend/Dockerfile
FROM python:3.11
WORKDIR /app
COPY . .
RUN pip install --no-cache-dir -r requirements.txt
CMD ["gunicorn", "--bind", "0.0.0.0:8000", "sawaed_app:app"]
EOT

# 2. Create docker-compose.yml
echo "🐘 Creating docker-compose.yml..."
cat << 'EOT' > docker-compose.yml
version: "3.8"
services:
  web:
    build: ./backend
    ports:
      - "8000:8000"
    depends_on:
      - db
    environment:
      - DATABASE_URL=postgresql://postgres:pass@db:5432/sawaed
  db:
    image: postgres:14
    restart: always
    environment:
      POSTGRES_USER=postgres
      POSTGRES_PASSWORD=pass
      POSTGRES_DB=sawaed
    volumes:
      - pgdata:/var/lib/postgresql/data
volumes:
  pgdata:
EOT

# 3. Create .env if not exists
echo "🔐 Creating .env for Flask backend..."
cat << 'EOT' > backend/.env
FLASK_ENV=production
DATABASE_URL=postgresql://postgres:pass@db:5432/sawaed
EOT

# 4. Update backend __init__.py to use DATABASE_URL
echo "⚙️ Updating backend DB config..."
cd backend
sed -i "s|sqlite:///sawaed.db|$DATABASE_URL|g" sawaed_app/__init__.py || true

# 5. Start Docker containers
echo "🚀 Launching containers..."
cd /opt/swaeduae
docker-compose down
docker-compose build
docker-compose up -d

echo "✅ Backend PostgreSQL + Docker deployment complete!"
