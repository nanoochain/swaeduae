#!/bin/bash

set -e

echo "🚀 Phase 3: Final Polishing and Fixes"

echo "🔧 Ensuring API services are complete..."
cat << 'EOL' > src/services/api.js
export async function getAdminStats() {
  const res = await fetch('/api/admin/stats');
  return await res.json();
}

export async function getUsers() {
  const res = await fetch('/api/admin/users');
  return await res.json();
}

export async function uploadKYC(data) {
  return await fetch('/api/kyc/upload', {
    method: 'POST',
    body: data
  });
}

export async function getKYCSubmissions() {
  const res = await fetch('/api/admin/kyc');
  return await res.json();
}

export async function verifyOTP(phone, code) {
  const res = await fetch('/api/verify-otp', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({ phone, code })
  });
  return await res.json();
}

export async function createPayment(data) {
  const res = await fetch('/api/payment', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify(data)
  });
  return await res.json();
}

export async function getPayments() {
  const res = await fetch('/api/admin/payments');
  return await res.json();
}
EOL

echo "🧱 Building frontend..."
npm run build

echo "✅ Phase 3 finalized successfully!"
