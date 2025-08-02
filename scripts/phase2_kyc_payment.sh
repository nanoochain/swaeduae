#!/bin/bash

set -e

echo "📦 Phase 2: UAE PASS, KYC, SMS OTP, and Payment Integration"

echo "🗂️ Creating required folders..."
mkdir -p src/pages/KYC src/pages/Payment src/pages/UAEPass src/pages/OTP src/pages/Admin
mkdir -p src/services

echo "📝 Writing API service (api.js)..."
cat << 'EOL' > src/services/api.js
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

echo "🧾 Creating KYCUpload.jsx..."
cat << 'EOL' > src/pages/KYC/KYCUpload.jsx
import React, { useState } from 'react';
import { uploadKYC } from '@/services/api';

export default function KYCUpload() {
  const [file, setFile] = useState(null);
  const handleSubmit = async (e) => {
    e.preventDefault();
    const formData = new FormData();
    formData.append('document', file);
    await uploadKYC(formData);
    alert('KYC submitted');
  };
  return (
    <form onSubmit={handleSubmit} className="p-4">
      <h2 className="text-xl font-bold mb-2">Upload KYC Document</h2>
      <input type="file" onChange={e => setFile(e.target.files[0])} />
      <button type="submit" className="btn btn-primary ml-2">Submit</button>
    </form>
  );
}
EOL

echo "🔐 Creating VerifyOTP.jsx..."
cat << 'EOL' > src/pages/OTP/VerifyOTP.jsx
import React, { useState } from 'react';
import { verifyOTP } from '@/services/api';

export default function VerifyOTP() {
  const [phone, setPhone] = useState('');
  const [code, setCode] = useState('');
  const handleSubmit = async (e) => {
    e.preventDefault();
    const res = await verifyOTP(phone, code);
    alert(res.message);
  };
  return (
    <form onSubmit={handleSubmit} className="p-4">
      <h2 className="text-xl font-bold mb-2">Verify OTP</h2>
      <input placeholder="Phone" value={phone} onChange={e => setPhone(e.target.value)} />
      <input placeholder="Code" value={code} onChange={e => setCode(e.target.value)} />
      <button className="btn btn-primary">Verify</button>
    </form>
  );
}
EOL

echo "💳 Creating PaymentForm.jsx..."
cat << 'EOL' > src/pages/Payment/PaymentForm.jsx
import React, { useState } from 'react';
import { createPayment } from '@/services/api';

export default function PaymentForm() {
  const [amount, setAmount] = useState('');
  const handleSubmit = async (e) => {
    e.preventDefault();
    const res = await createPayment({ amount });
    window.location.href = res.payment_url;
  };
  return (
    <form onSubmit={handleSubmit} className="p-4">
      <h2 className="text-xl font-bold mb-2">Make a Payment</h2>
      <input value={amount} onChange={e => setAmount(e.target.value)} placeholder="Amount AED" />
      <button className="btn btn-success ml-2">Pay</button>
    </form>
  );
}
EOL

echo "🛂 Creating AdminKYC.jsx + AdminPayments.jsx..."
cat << 'EOL' > src/pages/Admin/AdminKYC.jsx
import React, { useEffect, useState } from 'react';
import { getKYCSubmissions } from '@/services/api';

export default function AdminKYC() {
  const [docs, setDocs] = useState([]);
  useEffect(() => {
    getKYCSubmissions().then(setDocs);
  }, []);
  return (
    <div className="p-4">
      <h2 className="text-2xl font-bold mb-4">KYC Submissions</h2>
      <ul>{docs.map((d, i) => <li key={i}>{d.user} - <a href={d.link}>View</a></li>)}</ul>
    </div>
  );
}
EOL

cat << 'EOL' > src/pages/Admin/AdminPayments.jsx
import React, { useEffect, useState } from 'react';
import { getPayments } from '@/services/api';

export default function AdminPayments() {
  const [payments, setPayments] = useState([]);
  useEffect(() => {
    getPayments().then(setPayments);
  }, []);
  return (
    <div className="p-4">
      <h2 className="text-2xl font-bold mb-4">Payment Records</h2>
      <table className="table-auto w-full"><thead><tr><th>User</th><th>Amount</th><th>Status</th></tr></thead>
        <tbody>
          {payments.map((p, i) => (
            <tr key={i}><td>{p.user}</td><td>{p.amount}</td><td>{p.status}</td></tr>
          ))}
        </tbody>
      </table>
    </div>
  );
}
EOL

echo "📌 Updating App.jsx routes..."
sed -i "/<Routes>/a \\
        <Route path=\"/kyc-upload\" element={<KYCUpload />} />\n        <Route path=\"/verify-otp\" element={<VerifyOTP />} />\n        <Route path=\"/payment\" element={<PaymentForm />} />\n        <Route path=\"/admin/kyc\" element={<AdminKYC />} />\n        <Route path=\"/admin/payments\" element={<AdminPayments />} />" src/App.jsx

npm run build

echo "✅ Phase 2 components created and build completed."
echo "📤 Committing to GitHub..."
git add .
git commit -m "✅ Phase 2: UAE PASS, KYC Upload, OTP, Payment, Admin Review"
git remote set-url origin git@github.com:nanoochain/swaeduae.git
git push
