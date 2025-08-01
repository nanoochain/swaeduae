import React, { useState } from 'react';
import { verifyCertificatePublic, getCertificatePDF } from '@/services/api';

export default function CertificateVerify() {
  const [certId, setCertId] = useState('');
  const [result, setResult] = useState(null);

  const handleVerify = async () => {
    const res = await verifyCertificatePublic(certId);
    setResult(res);
  };

  return (
    <div>
      <h2>Verify Certificate</h2>
      <input value={certId} onChange={e => setCertId(e.target.value)} placeholder="Enter Certificate ID" />
      <button onClick={handleVerify}>Verify</button>
      {result && (
        <div>
          {result.status === 'valid'
            ? <a href={result.pdf_url} target="_blank" rel="noreferrer">Valid! Download PDF</a>
            : <span>Not valid</span>}
        </div>
      )}
    </div>
  );
}
