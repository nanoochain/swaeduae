import React, { useEffect, useState } from 'react';
import axios from 'axios';

export default function Certificates() {
  const [certificates, setCertificates] = useState([]);

  useEffect(() => {
    axios.get('/api/certificates').then(res => setCertificates(res.data));
  }, []);

  return (
    <div className="p-6">
      <h2 className="text-xl font-bold mb-4">My Certificates</h2>
      <ul className="space-y-2">
        {certificates.map(cert => (
          <li key={cert.id} className="p-2 border">
            <p>{cert.eventTitle}</p>
            <a href={cert.downloadUrl} className="text-blue-600 underline" target="_blank">Download PDF</a>
          </li>
        ))}
      </ul>
    </div>
  );
}
