import React, { useState } from 'react';
import { verifyCertificate } from '../services/api.js';

/*
 * Public page allowing anyone to verify a certificate's validity.
 * The backend exposes `/verify/<cert_id>` which returns a status of
 * "valid" or "invalid" and, if valid, a URL to the PDF file【861662118637036†L48-L53】.
 */
export default function VerifyCertificate() {
  const [certId, setCertId] = useState('');
  const [result, setResult] = useState(null);
  const handleSubmit = async (e) => {
    e.preventDefault();
    if (!certId) return;
    try {
      const res = await verifyCertificate(certId);
      setResult(res);
    } catch (err) {
      setResult({ status: 'error', error: err.message });
    }
  };
  return (
    <div>
      <h1>Verify Certificate</h1>
      <form onSubmit={handleSubmit}>
        <input
          type="text"
          placeholder="Certificate ID"
          value={certId}
          onChange={(e) => setCertId(e.target.value)}
        />
        <button type="submit">Verify</button>
      </form>
      {result && (
        <div style={{ marginTop: '1rem' }}>
          {result.status === 'valid' && (
            <>
              <p>Certificate is valid.</p>
              {result.pdf_url && (
                <a href={result.pdf_url} target="_blank" rel="noopener noreferrer">
                  Download PDF
                </a>
              )}
            </>
          )}
          {result.status === 'invalid' && <p>Certificate is invalid.</p>}
          {result.status === 'error' && <p>Error: {result.error}</p>}
        </div>
      )}
    </div>
  );
}