#!/bin/bash

echo "🔧 Fixing AdminCertificateVerify.jsx fetch syntax..."

cat << 'JSX' > src/pages/Admin/AdminCertificateVerify.jsx
import React, { useState } from 'react';

const AdminCertificateVerify = () => {
  const [certId, setCertId] = useState('');
  const [result, setResult] = useState(null);

  const verifyCertificate = async () => {
    try {
      const res = await fetch(`https://swaeduae.ae/api/verify/${certId}`);
      const data = await res.json();
      setResult(data);
    } catch (err) {
      setResult({ error: 'Verification failed' });
    }
  };

  return (
    <div className="p-4">
      <h2 className="text-xl font-bold mb-4">Admin Verify Certificate</h2>
      <input
        className="border p-2 mr-2"
        placeholder="Certificate ID"
        value={certId}
        onChange={(e) => setCertId(e.target.value)}
      />
      <button onClick={verifyCertificate} className="bg-indigo-500 text-white px-4 py-2">Verify</button>

      {result && (
        <div className="mt-4 bg-gray-100 p-2 rounded">
          <pre>{JSON.stringify(result, null, 2)}</pre>
        </div>
      )}
    </div>
  );
};

export default AdminCertificateVerify;
JSX

echo "✅ AdminCertificateVerify.jsx fixed."
