import React, { useEffect, useState } from 'react';
import axios from 'axios';

export default function EventList() {
  const [events, setEvents] = useState([]);
  const [filter, setFilter] = useState('');
  const [filteredEvents, setFilteredEvents] = useState([]);

  useEffect(() => {
    axios.get('/api/events')
      .then(res => {
        setEvents(res.data.events);
        setFilteredEvents(res.data.events);
      });
  }, []);

  useEffect(() => {
    setFilteredEvents(
      events.filter(ev =>
        ev.name.toLowerCase().includes(filter.toLowerCase())
      )
    );
  }, [filter, events]);

  return (
    <div className="p-6 max-w-5xl mx-auto">
      <h2 className="text-3xl font-bold mb-6" style={{ color: '#50C878' }}>Volunteer Events</h2>
      <input
        type="text"
        placeholder="Search events..."
        value={filter}
        onChange={e => setFilter(e.target.value)}
        className="border border-green-400 p-2 rounded mb-4 w-full"
      />
      {filteredEvents.length === 0 ? (
        <p>No events found.</p>
      ) : (
        <ul>
          {filteredEvents.map(ev => (
            <li key={ev.id} className="mb-4 p-4 border rounded border-green-300">
              <h3 className="font-semibold text-xl">{ev.name}</h3>
              <p>From {new Date(ev.start_date).toLocaleDateString()} to {new Date(ev.end_date).toLocaleDateString()}</p>
              <p>Organization: {ev.organization_name}</p>
              <a
                href={`/event/${ev.id}`}
                className="mt-2 inline-block px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700"
              >
                View Details
              </a>
            </li>
          ))}
        </ul>
      )}
    </div>
  );
}
