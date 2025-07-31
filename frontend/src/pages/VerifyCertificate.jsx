import React, { useState } from 'react';
import { verifyCertificate } from '@/services/api';

export default function VerifyCertificate() {
  const [certId, setCertId] = useState('');
  const [result, setResult] = useState(null);

  const handleVerify = async e => {
    e.preventDefault();
    const res = await api.get(`/verify/${certId}`);
    setResult(res.data);
  };

  return (
    <div className="max-w-lg mx-auto p-8">
      <h2 className="text-2xl font-bold mb-4">Verify Certificate</h2>
      <form onSubmit={handleVerify} className="flex gap-2 mb-4">
        <input className="border px-2 rounded" placeholder="Certificate ID" value={certId} onChange={e => setCertId(e.target.value)} required />
        <button className="btn btn-primary">Verify</button>
      </form>
      {result && (
        <div className="p-4 border rounded bg-gray-50">
          {result.status === 'valid' ? (
            <div>
              <p><b>User:</b> {result.user}</p>
              <p><b>Event:</b> {result.event_id}</p>
              <p><b>Issued At:</b> {result.issued_at}</p>
              <a className="text-blue-500 underline" href={result.cert_url} target="_blank" rel="noreferrer">Download Certificate</a>
            </div>
          ) : (
            <p className="text-red-500 font-bold">Certificate not found or invalid.</p>
          )}
        </div>
      )}
    </div>
  );
}
