#!/bin/bash
# update_certificates_ui.sh
# Auto-generated script to update Certificate UI components

echo "📦 Updating Certificate Components..."

cd /opt/swaeduae/frontend/src/pages

# Volunteer Certificate Viewer
cat << 'EOF' > VolunteerCertificates.jsx
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
EOF

# Admin Certificate Sender
cat << 'EOF' > AdminSendCertificates.jsx
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
EOF

# Public Verification Page
cat << 'EOF' > VerifyCertificate.jsx
import React, { useEffect, useState } from 'react';
import { useParams } from 'react-router-dom';
import axios from 'axios';

const VerifyCertificate = () => {
  const { cert_id } = useParams();
  const [status, setStatus] = useState(null);

  useEffect(() => {
    axios.get(`/verify/${cert_id}`)
      .then(res => setStatus(res.data.message))
      .catch(() => setStatus("❌ الشهادة غير موجودة أو غير صالحة"));
  }, [cert_id]);

  return (
    <div className="p-4">
      <h1 className="text-2xl font-bold mb-4">🔍 تحقق من الشهادة</h1>
      <p className="text-lg">{status}</p>
    </div>
  );
};

export default VerifyCertificate;
EOF

# Update routing
cd /opt/swaeduae/frontend/src

sed -i "/import .*Dashboard.*/a import VolunteerCertificates from './pages/VolunteerCertificates';\nimport AdminSendCertificates from './pages/AdminSendCertificates';\nimport VerifyCertificate from './pages/VerifyCertificate';" App.jsx

sed -i "/<Route path=\"\\/dashboard\" element={<Dashboard \/>} \/>/a \\
<Route path=\"/certificates\" element={<VolunteerCertificates />} />\n<Route path=\"/admin/send-certificates\" element={<AdminSendCertificates />} />\n<Route path=\"/verify/:cert_id\" element={<VerifyCertificate />} />
" App.jsx

echo "✅ Certificate components and routes updated!"
