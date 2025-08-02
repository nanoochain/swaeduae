#!/bin/bash
set -e

# 1. Backend Python venv & dependencies
cd /opt/swaeduae/backend
python3 -m venv venv
source venv/bin/activate
pip install --upgrade pip
pip install -r requirements.txt

# 2. Backend .env
cat <<EENV > /opt/swaeduae/backend/.env
FLASK_ENV=production
DATABASE_URL=postgresql://postgres:pass@localhost:5432/sawaed
JWT_SECRET_KEY=your-very-secret-jwt-key
MAIL_SERVER=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your@email.com
MAIL_PASSWORD=yourpassword
MAIL_USE_TLS=True
MAIL_USE_SSL=False
EENV

# 3. PostgreSQL setup
apt update
apt install postgresql postgresql-contrib -y
sudo -u postgres psql <<EOSQL
CREATE DATABASE sawaed;
CREATE USER postgres WITH PASSWORD 'pass';
GRANT ALL PRIVILEGES ON DATABASE sawaed TO postgres;
EOSQL

# 4. DB migration
cd /opt/swaeduae/backend
source venv/bin/activate
flask db upgrade

# 5. Gunicorn systemd service
cat <<ESVC > /etc/systemd/system/swaeduae-backend.service
[Unit]
Description=SawaedUAE Flask API with Gunicorn
After=network.target

[Service]
User=root
Group=root
WorkingDirectory=/opt/swaeduae/backend
Environment="PATH=/opt/swaeduae/backend/venv/bin"
ExecStart=/opt/swaeduae/backend/venv/bin/gunicorn --workers 3 --bind 127.0.0.1:5000 wsgi:app

[Install]
WantedBy=multi-user.target
ESVC

systemctl daemon-reload
systemctl enable swaeduae-backend
systemctl restart swaeduae-backend

# 6. Frontend .env & build
cd /opt/swaeduae/frontend
cat <<EENV2 > .env
VITE_API_URL=https://swaeduae.ae
EENV2

rm -rf node_modules package-lock.json dist
npm install
npm run build

# 7. Nginx config
cat <<ENGINX > /etc/nginx/sites-available/swaeduae.ae
server {
    listen 80;
    server_name swaeduae.ae www.swaeduae.ae;

    location / {
        root /opt/swaeduae/frontend/dist;
        try_files \$uri \$uri/ /index.html;
    }

    location /api/ {
        proxy_pass http://127.0.0.1:5000/;
        proxy_set_header Host \$host;
        proxy_set_header X-Real-IP \$remote_addr;
        proxy_set_header X-Forwarded-For \$proxy_add_x_forwarded_for;
        proxy_set_header X-Forwarded-Proto \$scheme;
    }

    location /events {
        proxy_pass http://127.0.0.1:5000/events;
        proxy_set_header Host \$host;
        proxy_set_header X-Real-IP \$remote_addr;
        proxy_set_header X-Forwarded-For \$proxy_add_x_forwarded_for;
        proxy_set_header X-Forwarded-Proto \$scheme;
    }

    location /certificates {
        proxy_pass http://127.0.0.1:5000/certificates;
        proxy_set_header Host \$host;
        proxy_set_header X-Real-IP \$remote_addr;
        proxy_set_header X-Forwarded-For \$proxy_add_x_forwarded_for;
        proxy_set_header X-Forwarded-Proto \$scheme;
    }

    location /socket.io {
        proxy_pass http://127.0.0.1:5000/socket.io;
        proxy_http_version 1.1;
        proxy_set_header Upgrade \$http_upgrade;
        proxy_set_header Connection "upgrade";
        proxy_set_header Host \$host;
    }

    client_max_body_size 100M;
}
ENGINX

ln -sf /etc/nginx/sites-available/swaeduae.ae /etc/nginx/sites-enabled/swaeduae.ae
nginx -t
systemctl reload nginx

# 8. SSL with certbot
apt install certbot python3-certbot-nginx -y
certbot --nginx -d swaeduae.ae -d www.swaeduae.ae --non-interactive --agree-tos --email whitewooolf@hotmail.com

echo "🚀 All done! Visit https://swaeduae.ae"
