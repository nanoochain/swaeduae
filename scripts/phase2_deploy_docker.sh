#!/bin/bash

echo "🚀 Phase 2: Final Deployment Setup (Single Domain)..."

cd /opt/swaeduae

### 1. Dockerfile
echo "📦 Creating Dockerfile..."
cat << 'DOCKER' > backend/Dockerfile
FROM python:3.12-slim

WORKDIR /app
COPY requirements.txt ./
RUN pip install --no-cache-dir -r requirements.txt
COPY . .
CMD ["gunicorn", "-b", "0.0.0.0:5000", "sawaed_app:app"]
DOCKER

### 2. docker-compose.yml
echo "📦 Creating docker-compose.yml..."
cat << 'YML' > docker-compose.yml
version: '3.9'
services:
  backend:
    build: ./backend
    container_name: swaeduae-backend
    ports:
      - "5000:5000"
    volumes:
      - ./backend:/app
    restart: always
YML

### 3. Gunicorn systemd service
echo "⚙️ Creating Gunicorn service..."
cat << 'SERVICE' > /etc/systemd/system/sawaed.service
[Unit]
Description=SawaedUAE Gunicorn Service
After=network.target

[Service]
User=root
Group=www-data
WorkingDirectory=/opt/swaeduae/backend
Environment="PATH=/opt/swaeduae/backend/venv/bin"
ExecStart=/opt/swaeduae/backend/venv/bin/gunicorn -w 4 -b 0.0.0.0:5000 sawaed_app:app

[Install]
WantedBy=multi-user.target
SERVICE

systemctl daemon-reexec
systemctl daemon-reload
systemctl enable sawaed
systemctl restart sawaed

### 4. Nginx config (frontend + backend on swaeduae.ae)
echo "🌐 Creating Nginx config for swaeduae.ae..."
cat << 'NGINX' > /etc/nginx/sites-available/swaeduae.ae
server {
    listen 80;
    server_name swaeduae.ae www.swaeduae.ae;

    location / {
        root /opt/swaeduae/frontend/dist;
        index index.html;
        try_files $uri $uri/ /index.html;
    }

    location /api/ {
        proxy_pass http://localhost:5000/;
        proxy_set_header Host $host;
        proxy_set_header X-Real-IP $remote_addr;
        proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
    }
}
NGINX

ln -sf /etc/nginx/sites-available/swaeduae.ae /etc/nginx/sites-enabled/swaeduae.ae
nginx -t && systemctl reload nginx

### 5. SSL setup for swaeduae.ae only
echo "🔐 Installing SSL via Certbot..."
apt-get install -y certbot python3-certbot-nginx
certbot --nginx -d swaeduae.ae -d www.swaeduae.ae --non-interactive --agree-tos -m you@swaeduae.ae

### 6. GitHub Actions CI/CD (optional)
echo "⚙️ Creating GitHub Actions workflow..."
mkdir -p backend/.github/workflows
cat << 'YML' > backend/.github/workflows/deploy.yml
name: Deploy Backend

on:
  push:
    branches: [main]

jobs:
  build:
    runs-on: ubuntu-latest
    steps:
      - name: SSH Deploy
        uses: appleboy/ssh-action@v1.0.3
        with:
          host: ${{ secrets.SSH_HOST }}
          username: ${{ secrets.SSH_USER }}
          key: ${{ secrets.SSH_KEY }}
          script: |
            cd /opt/swaeduae
            git pull origin main
            systemctl restart sawaed
YML

echo "📤 Committing deployment config to GitHub..."
cd backend
git add Dockerfile .github ../docker-compose.yml
git commit -m "🚀 Phase 2: Deployment with SSL and single domain (swaeduae.ae)"
git push origin main

echo "✅ Phase 2 Complete: App deployed under swaeduae.ae with Docker + Gunicorn + SSL"
