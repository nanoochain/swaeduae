import React, { useEffect, useState } from 'react';
import { getVolunteerCertificates, verifyCertificate } from '@/services/api';

export default function AdminCertApprove() {
  const [certs, setCerts] = useState([]);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    getVolunteerCertificates()
      .then((data) => setCerts(data))
      .finally(() => setLoading(false));
  }, []);

  const handleVerify = async (cert_id) => {
    await verifyCertificate(cert_id);
    const updated = await getVolunteerCertificates();
    setCerts(updated);
  };

  if (loading) return <div>Loading...</div>;

  return (
    <div>
      <h2>Volunteer Certificates</h2>
      <ul>
        {certs.map((cert) => (
          <li key={cert.id}>
            {cert.name} ({cert.status})
            {cert.status !== 'verified' && (
              <button onClick={() => handleVerify(cert.id)}>Verify</button>
            )}
          </li>
        ))}
      </ul>
    </div>
  );
}
