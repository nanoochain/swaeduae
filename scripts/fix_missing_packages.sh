#!/bin/bash
set -e

echo "🔧 Installing missing dependencies..."
npm install react-router-dom
npm install -D tailwindcss postcss autoprefixer @tailwindcss/postcss

echo "🔍 Running audit fix (forced)..."
npm audit fix --force || true

echo "🧹 Cleaning old dist..."
rm -rf dist

echo "🏗️ Building project..."
npm run build

echo "✅ Done. If no errors above, your frontend should now be production-ready."
