// CertificateSender.jsx
import React, { useState } from 'react';
import axios from 'axios';

const CertificateSender = ({ cert }) => {
  const [email, setEmail] = useState('');
  const [phone, setPhone] = useState('');
  const [message, setMessage] = useState('');

  const sendCertificate = async () => {
    try {
      await axios.post('/certificates/send', {
        cert_id: cert.id,
        email,
        phone,
      });
      setMessage('✅ Certificate sent!');
    } catch {
      setMessage('❌ Failed to send certificate.');
    }
  };

  return (
    <div className="space-y-2 mt-4">
      <input
        type="email"
        placeholder="Recipient Email"
        value={email}
        onChange={(e) => setEmail(e.target.value)}
        className="w-full p-2 border rounded"
      />
      <input
        type="text"
        placeholder="WhatsApp Number"
        value={phone}
        onChange={(e) => setPhone(e.target.value)}
        className="w-full p-2 border rounded"
      />
      <button onClick={sendCertificate} className="bg-purple-600 text-white px-4 py-2 rounded hover:bg-purple-700">
        Send Certificate
      </button>
      {message && <p className="text-sm">{message}</p>}
    </div>
  );
};

export default CertificateSender;
