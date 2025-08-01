#!/bin/bash

echo "🔧 Fixing certificate fetch URLs..."

# 1. Fix AdminSendCertificate.jsx
cat << 'JSX' > src/pages/Certificate/AdminSendCertificate.jsx
import React, { useState } from 'react';

const AdminSendCertificate = () => {
  const [certId, setCertId] = useState('');
  const [method, setMethod] = useState('email');
  const [result, setResult] = useState(null);

  const handleSend = async () => {
    try {
      const res = await fetch(`https://swaeduae.ae/api/certificates/send`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ certificate_id: parseInt(certId), method }),
      });
      const data = await res.json();
      setResult(data);
    } catch (error) {
      setResult({ error: 'Failed to send certificate' });
    }
  };

  return (
    <div className="p-4">
      <h2 className="text-xl font-bold mb-4">Send Certificate</h2>
      <input
        className="border p-2 mr-2"
        placeholder="Certificate ID"
        value={certId}
        onChange={(e) => setCertId(e.target.value)}
      />
      <select className="border p-2 mr-2" value={method} onChange={(e) => setMethod(e.target.value)}>
        <option value="email">Email</option>
        <option value="whatsapp">WhatsApp</option>
      </select>
      <button onClick={handleSend} className="bg-blue-500 text-white px-4 py-2">Send</button>

      {result && (
        <div className="mt-4 bg-gray-100 p-2 rounded">
          <pre>{JSON.stringify(result, null, 2)}</pre>
        </div>
      )}
    </div>
  );
};

export default AdminSendCertificate;
JSX

# 2. Fix VerifyCertificate.jsx
cat << 'JSX' > src/pages/Certificate/VerifyCertificate.jsx
import React, { useState } from 'react';

const VerifyCertificate = () => {
  const [certId, setCertId] = useState('');
  const [result, setResult] = useState(null);

  const handleVerify = async () => {
    const res = await fetch(`https://swaeduae.ae/api/verify/${certId}`);
    const data = await res.json();
    setResult(data);
  };

  return (
    <div className="p-4">
      <h2 className="text-xl font-bold mb-4">Verify Certificate</h2>
      <input
        className="border p-2 mr-2"
        placeholder="Certificate ID"
        value={certId}
        onChange={(e) => setCertId(e.target.value)}
      />
      <button onClick={handleVerify} className="bg-green-600 text-white px-4 py-2">Verify</button>

      {result && (
        <div className="mt-4 bg-gray-100 p-2 rounded">
          <pre>{JSON.stringify(result, null, 2)}</pre>
        </div>
      )}
    </div>
  );
};

export default VerifyCertificate;
JSX

echo "✅ Certificate UI URLs updated to use swaeduae.ae domain"
