import React, { useState, useEffect } from 'react';
import axios from 'axios';

const AdminSendCertificates = () => {
  const [certs, setCerts] = useState([]);

  useEffect(() => {
    axios.get('/admin/certificates', {
      headers: { Authorization: `Bearer ${localStorage.getItem('token')}` }
    }).then(res => setCerts(res.data));
  }, []);

  const send = (id, method) => {
    axios.post('/certificates/send', { cert_id: id, method }, {
      headers: { Authorization: `Bearer ${localStorage.getItem('token')}` }
    })
    .then(() => alert(`Sent via ${method}`))
    .catch(() => alert('Error sending certificate'));
  };

  return (
    <div className="p-4">
      <h2 className="text-xl font-bold mb-4">🎓 إرسال الشهادات</h2>
      <ul>
        {certs.map(cert => (
          <li key={cert.id} className="p-2 border rounded my-2">
            👤 {cert.volunteer_name} - 📅 {cert.event_name}
            <div className="space-x-2 mt-2">
              <button onClick={() => send(cert.id, 'email')} className="bg-blue-500 text-white px-3 py-1 rounded">📧 بريد إلكتروني</button>
              <button onClick={() => send(cert.id, 'whatsapp')} className="bg-green-500 text-white px-3 py-1 rounded">📱 واتساب</button>
            </div>
          </li>
        ))}
      </ul>
    </div>
  );
};

export default AdminSendCertificates;
