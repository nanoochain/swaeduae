// MyEvents.jsx
import React, { useEffect, useState } from 'react';
import axios from 'axios';

const MyEvents = () => {
  const [events, setEvents] = useState([]);

  useEffect(() => {
    const fetch = async () => {
      const res = await axios.get('/my-events');
      setEvents(res.data);
    };
    fetch();
  }, []);

  return (
    <div className="p-6 max-w-2xl mx-auto">
      <h1 className="text-2xl font-bold mb-4">My Registered Events</h1>
      {events.length === 0 ? (
        <p>You have not registered for any events yet.</p>
      ) : (
        <ul className="space-y-4">
          {events.map(ev => (
            <li key={ev.id} className="border p-4 rounded shadow bg-white dark:bg-gray-800">
              <h2 className="text-lg font-semibold">{ev.title}</h2>
              <p>Date: {new Date(ev.date).toLocaleDateString()}</p>
              <p>Location: {ev.location}</p>
            </li>
          ))}
        </ul>
      )}
    </div>
  );
};

export default MyEvents;
