#!/bin/bash

echo "📦 Setting up Nginx config..."
cat << 'EON' > /etc/nginx/sites-available/swaeduae.ae.conf
server {
    listen 80;
    server_name swaeduae.ae www.swaeduae.ae;
    return 301 https://\$host\$request_uri;
}

server {
    listen 443 ssl;
    server_name swaeduae.ae www.swaeduae.ae;

    ssl_certificate /etc/letsencrypt/live/swaeduae.ae/fullchain.pem;
    ssl_certificate_key /etc/letsencrypt/live/swaeduae.ae/privkey.pem;

    root /var/www/swaeduae.ae;
    index index.html;

    location / {
        try_files \$uri \$uri/ /index.html;
    }

    location /api/ {
        proxy_pass http://127.0.0.1:5000/;
        proxy_set_header Host \$host;
        proxy_set_header X-Real-IP \$remote_addr;
        proxy_set_header X-Forwarded-For \$proxy_add_x_forwarded_for;
    }
}
EON

ln -sf /etc/nginx/sites-available/swaeduae.ae.conf /etc/nginx/sites-enabled/swaeduae.ae.conf
nginx -t && systemctl reload nginx

echo "🌐 Building frontend..."
cd /opt/swaeduae/frontend
echo "VITE_API_URL=https://swaeduae.ae/api" > .env.production

npm run build

echo "🚚 Deploying files to /var/www/swaeduae.ae"
rm -rf /var/www/swaeduae.ae/*
cp -r dist/* /var/www/swaeduae.ae/

echo "✅ Deployment complete. Visit: https://swaeduae.ae"
