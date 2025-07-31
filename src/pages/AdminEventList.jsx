// AdminEventList.jsx
import React, { useEffect, useState } from 'react';
import axios from 'axios';
import { Link } from 'react-router-dom';

const AdminEventList = () => {
  const [events, setEvents] = useState([]);

  useEffect(() => {
    const fetch = async () => {
      const res = await axios.get('/admin/events');
      setEvents(res.data);
    };
    fetch();
  }, []);

  return (
    <div className="p-6 max-w-4xl mx-auto">
      <h1 className="text-2xl font-bold mb-4">All Events (Admin View)</h1>
      {events.map(ev => (
        <div key={ev.id} className="border rounded p-4 mb-4 shadow bg-white dark:bg-gray-800">
          <h2 className="text-lg font-semibold">{ev.title}</h2>
          <p>Date: {new Date(ev.date).toLocaleDateString()}</p>
          <p>Location: {ev.location}</p>
          <p>Registrations: {ev.registrations}</p>
          <Link
            to={`/admin/events/${ev.id}/volunteers`}
            className="inline-block mt-2 text-blue-600 hover:underline"
          >
            View Volunteers
          </Link>
        </div>
      ))}
    </div>
  );
};

export default AdminEventList;
