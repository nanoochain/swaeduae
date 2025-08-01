// AdminCertificateIssuer.jsx
import React, { useState } from 'react';
import axios from 'axios';

const AdminCertificateIssuer = () => {
  const [form, setForm] = useState({
    volunteer_name: '',
    event_name: '',
    issue_date: '',
  });
  const [status, setStatus] = useState('');

  const handleChange = (e) => {
    setForm({ ...form, [e.target.name]: e.target.value });
  };

  const handleIssue = async (e) => {
    e.preventDefault();
    try {
      await axios.post('/certificates', form);
      setStatus('✅ Certificate issued successfully!');
      setForm({ volunteer_name: '', event_name: '', issue_date: '' });
    } catch {
      setStatus('❌ Error issuing certificate.');
    }
  };

  return (
    <div className="p-6 max-w-lg mx-auto">
      <h1 className="text-2xl font-bold mb-4">Issue Certificate</h1>
      <form onSubmit={handleIssue} className="space-y-4">
        <input
          name="volunteer_name"
          value={form.volunteer_name}
          onChange={handleChange}
          placeholder="Volunteer Name"
          required
          className="w-full p-2 border rounded"
        />
        <input
          name="event_name"
          value={form.event_name}
          onChange={handleChange}
          placeholder="Event Name"
          required
          className="w-full p-2 border rounded"
        />
        <input
          type="date"
          name="issue_date"
          value={form.issue_date}
          onChange={handleChange}
          required
          className="w-full p-2 border rounded"
        />
        <button type="submit" className="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
          Issue Certificate
        </button>
        {status && <p className="text-sm">{status}</p>}
      </form>
    </div>
  );
};

export default AdminCertificateIssuer;
