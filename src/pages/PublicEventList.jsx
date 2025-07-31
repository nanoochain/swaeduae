// PublicEventList.jsx
import React, { useEffect, useState } from 'react';
import axios from 'axios';

const PublicEventList = () => {
  const [events, setEvents] = useState([]);

  useEffect(() => {
    const fetchEvents = async () => {
      const res = await axios.get('/events/public');
      setEvents(res.data);
    };
    fetchEvents();
  }, []);

  return (
    <div className="p-6 max-w-3xl mx-auto">
      <h1 className="text-2xl font-bold mb-4">Upcoming Volunteer Events</h1>
      {events.map(event => (
        <div key={event.id} className="border rounded p-4 mb-4 shadow bg-white dark:bg-gray-800">
          <h2 className="text-lg font-semibold">{event.title}</h2>
          <p>Date: {new Date(event.date).toLocaleDateString()}</p>
          <p>Location: {event.location}</p>
        </div>
      ))}
    </div>
  );
};

export default PublicEventList;
