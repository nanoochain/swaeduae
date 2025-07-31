import React, { useEffect, useState } from 'react';
import { getVolunteerCertificates } from '@/services/api';

export default function VolunteerCertificates() {
  const [certificates, setCertificates] = useState([]);
  useEffect(() => {
    getVolunteerCertificates().then(setCertificates);
  }, []);
  return (
    <div className="p-4">
      <h2 className="text-2xl font-bold mb-4">My Certificates</h2>
      <ul>
        {certificates.map(cert => (
          <li key={cert.id} className="mb-2">
            Event: {cert.event_id} | Issued: {cert.issued_at} <br />
            <a href={cert.cert_url} className="text-blue-500 underline" target="_blank" rel="noopener noreferrer">
              View/Download
            </a>
          </li>
        ))}
      </ul>
    </div>
  );
}
