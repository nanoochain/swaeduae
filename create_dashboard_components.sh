#!/bin/bash
cd /opt/swaeduae/frontend

echo "🛠️ Creating Admin Event Creation UI..."
mkdir -p src/pages/Admin
cat << 'EOF' > src/pages/Admin/AdminEventCreation.jsx
import React, { useState } from 'react';
import axios from 'axios';

export default function AdminEventCreation() {
  const [formData, setFormData] = useState({
    title: '',
    description: '',
    date: '',
    location: ''
  });

  const handleChange = (e) => {
    setFormData({ ...formData, [e.target.name]: e.target.value });
  };

  const handleSubmit = async (e) => {
    e.preventDefault();
    try {
      await axios.post('/api/events', formData);
      alert('Event created successfully');
    } catch (err) {
      alert('Error creating event');
    }
  };

  return (
    <div className="p-6">
      <h2 className="text-xl font-bold mb-4">Create Event</h2>
      <form onSubmit={handleSubmit} className="space-y-4">
        <input name="title" onChange={handleChange} placeholder="Title" className="input" />
        <input name="description" onChange={handleChange} placeholder="Description" className="input" />
        <input name="date" type="date" onChange={handleChange} className="input" />
        <input name="location" onChange={handleChange} placeholder="Location" className="input" />
        <button type="submit" className="btn btn-primary">Create</button>
      </form>
    </div>
  );
}
EOF

echo "👤 Creating Volunteer Profile Page..."
cat << 'EOF' > src/pages/Profile.jsx
import React, { useEffect, useState } from 'react';
import axios from 'axios';

export default function Profile() {
  const [user, setUser] = useState(null);

  useEffect(() => {
    axios.get('/api/profile').then(res => {
      setUser(res.data);
    });
  }, []);

  if (!user) return <p>Loading...</p>;

  return (
    <div className="p-6">
      <h2 className="text-2xl font-bold mb-2">Welcome, {user.username}</h2>
      <p>Email: {user.email}</p>
      <p>Role: {user.role}</p>
    </div>
  );
}
EOF

echo "📄 Creating Certificate Viewer & Generator..."
cat << 'EOF' > src/pages/Certificates.jsx
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
EOF

echo "📊 Creating Admin Dashboard..."
cat << 'EOF' > src/pages/Admin/AdminDashboard.jsx
import React, { useEffect, useState } from 'react';
import axios from 'axios';

export default function AdminDashboard() {
  const [stats, setStats] = useState({ users: 0, events: 0, certificates: 0 });

  useEffect(() => {
    axios.get('/api/admin/stats').then(res => {
      setStats(res.data);
    });
  }, []);

  return (
    <div className="p-6 grid grid-cols-1 md:grid-cols-3 gap-4">
      <div className="p-4 bg-white shadow rounded">👥 Users: {stats.users}</div>
      <div className="p-4 bg-white shadow rounded">📅 Events: {stats.events}</div>
      <div className="p-4 bg-white shadow rounded">📜 Certificates: {stats.certificates}</div>
    </div>
  );
}
EOF

echo "✅ Components created successfully."
echo "🌀 Don't forget to update your router in src/App.jsx to include the new routes."
