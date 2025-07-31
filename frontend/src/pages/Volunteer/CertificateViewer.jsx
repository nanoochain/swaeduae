import React, { useEffect, useState } from 'react';
import { getVolunteerCertificates, sendCertificate, getCertificatePDF } from '@/services/api';

export default function CertificateViewer() {
  const [certs, setCerts] = useState([]);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    getVolunteerCertificates()
      .then(setCerts)
      .finally(() => setLoading(false));
  }, []);

  const handleSend = (cert_id) => {
    sendCertificate(cert_id, "email")
      .then(() => alert("Sent!"));
  };

  if (loading) return <div>Loading...</div>;

  return (
    <div>
      <h2>My Certificates</h2>
      <ul>
        {certs.map(cert => (
          <li key={cert.id}>
            {cert.event_name || cert.cert_url || cert.id} - {cert.status}
            {cert.status === "approved" &&
              <>
                <a href={getCertificatePDF(cert.id)} target="_blank" rel="noreferrer">Download PDF</a>
                <button onClick={() => handleSend(cert.id)}>Send by Email</button>
              </>
            }
          </li>
        ))}
      </ul>
    </div>
  );
}
