import React, { useEffect, useState } from 'react';
import { getEvents } from '../services/api';

export default function Events() {
  const [events, setEvents] = useState([]);
  const [error, setError] = useState(null);

  useEffect(() => {
    getEvents()
      .then(setEvents)
      .catch((err) => setError(err.message));
  }, []);

  return (
    <div className="p-4">
      <h1 className="text-2xl font-bold mb-2">Upcoming Events</h1>
      {error && <p className="text-red-500">{error}</p>}
      {events.length === 0 ? (
        <p>No events available.</p>
      ) : (
        <ul className="list-disc ml-4">
          {events.map((event) => (
            <li key={event.id}>{event.name} – {event.date}</li>
          ))}
        </ul>
      )}
    </div>
  );
}
