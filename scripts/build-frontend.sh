#!/bin/bash
# scripts/build-frontend.sh

echo "📦 Building frontend for production..."
cd /opt/swaeduae/frontend
npm install
npm run build
echo "✅ Frontend built successfully."
