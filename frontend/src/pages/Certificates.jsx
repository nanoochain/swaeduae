import React, { useEffect, useState } from 'react';
import { getCertificates } from '../services/api';

export default function Certificates() {
  const [certs, setCerts] = useState([]);
  const [error, setError] = useState(null);

  useEffect(() => {
    const token = localStorage.getItem('token');
    getCertificates(token)
      .then(setCerts)
      .catch((err) => setError(err.message));
  }, []);

  return (
    <div className="p-4">
      <h1 className="text-2xl font-bold mb-2">My Certificates</h1>
      {error && <p className="text-red-500">{error}</p>}
      {certs.length === 0 ? (
        <p>No certificates issued.</p>
      ) : (
        <ul className="list-disc ml-4">
          {certs.map((c) => (
            <li key={c.id}>{c.title} – Issued {c.date}</li>
          ))}
        </ul>
      )}
    </div>
  );
}
