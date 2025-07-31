// AdminEventVolunteers.jsx
import React, { useEffect, useState } from 'react';
import axios from 'axios';
import { useParams } from 'react-router-dom';

const AdminEventVolunteers = () => {
  const { eventId } = useParams();
  const [volunteers, setVolunteers] = useState([]);

  useEffect(() => {
    const fetchVolunteers = async () => {
      const res = await axios.get(`/admin/events/${eventId}/volunteers`);
      setVolunteers(res.data);
    };
    fetchVolunteers();
  }, [eventId]);

  const approve = async (registrationId) => {
    await axios.post(`/admin/events/${eventId}/approve`, {
      registration_id: registrationId,
    });
    setVolunteers(vs =>
      vs.map(v => v.id === registrationId ? { ...v, is_approved: true } : v)
    );
  };

  return (
    <div className="p-6 max-w-2xl mx-auto">
      <h1 className="text-2xl font-bold mb-4">Volunteers for Event #{eventId}</h1>
      {volunteers.length === 0 ? (
        <p>No volunteers registered.</p>
      ) : (
        <ul className="space-y-4">
          {volunteers.map(v => (
            <li key={v.id} className="border p-4 rounded shadow bg-white dark:bg-gray-800">
              <p><strong>{v.username}</strong> ({v.email})</p>
              <p>Status: {v.is_approved ? '✅ Approved' : '❌ Pending'}</p>
              {!v.is_approved && (
                <button
                  onClick={() => approve(v.id)}
                  className="mt-2 px-4 py-1 bg-green-600 text-white rounded hover:bg-green-700"
                >
                  Approve
                </button>
              )}
            </li>
          ))}
        </ul>
      )}
    </div>
  );
};

export default AdminEventVolunteers;
