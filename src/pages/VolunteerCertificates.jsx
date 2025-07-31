import React, { useEffect, useState } from 'react';
import axios from 'axios';

const VolunteerCertificates = () => {
  const [certs, setCerts] = useState([]);

  useEffect(() => {
    const token = localStorage.getItem('token');
    axios.get('/certificates', {
      headers: { Authorization: `Bearer ${token}` }
    })
    .then(res => setCerts(res.data))
    .catch(err => console.error(err));
  }, []);

  return (
    <div className="p-4">
      <h1 className="text-xl font-bold mb-4">📄 شهادات التطوع</h1>
      <ul>
        {certs.map(cert => (
          <li key={cert.id} className="border p-2 my-2 rounded shadow">
            🧾 {cert.event_name} - <a className="text-blue-600 underline" href={cert.download_url}>تنزيل PDF</a>
          </li>
        ))}
      </ul>
    </div>
  );
};

export default VolunteerCertificates;
