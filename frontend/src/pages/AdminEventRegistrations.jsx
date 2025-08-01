import React, { useEffect, useState } from 'react';
import { useAuth } from '../context/AuthContext';

const AdminEventRegistrations = () => {
  const { token, user } = useAuth();
  const [registrations, setRegistrations] = useState([]);

  useEffect(() => {
    fetch('/events/registrations', {
      headers: { Authorization: `Bearer ${token}` }
    })
      .then(res => res.json())
      .then(data => setRegistrations(data.registrations || []))
      .catch(console.error);
  }, [token]);

  const handleApprove = async (id) => {
    await fetch(`/events/registrations/${id}/approve`, {
      method: 'POST',
      headers: { Authorization: `Bearer ${token}` }
    });
    setRegistrations(r => r.filter(reg => reg.registration_id !== id));
  };

  const handleReject = async (id) => {
    await fetch(`/events/registrations/${id}/reject`, {
      method: 'POST',
      headers: { Authorization: `Bearer ${token}` }
    });
    setRegistrations(r => r.filter(reg => reg.registration_id !== id));
  };

  if (user.role !== 'admin' && user.role !== 'org_admin') {
    return <p>Access Denied</p>;
  }

  return (
    <div>
      <h1>Pending Event Registrations</h1>
      {registrations.length === 0 && <p>No pending registrations.</p>}
      <ul>
        {registrations.map(reg => (
          <li key={reg.registration_id}>
            {reg.username} - {reg.event_name}
            <button onClick={() => handleApprove(reg.registration_id)}>Approve</button>
            <button onClick={() => handleReject(reg.registration_id)}>Reject</button>
          </li>
        ))}
      </ul>
    </div>
  );
};

export default AdminEventRegistrations;
