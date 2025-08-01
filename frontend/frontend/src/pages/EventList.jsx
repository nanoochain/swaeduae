// EventList.jsx
import React, { useEffect, useState } from 'react';
import axios from 'axios';

const EventList = () => {
  const [events, setEvents] = useState([]);
  const [registeredIds, setRegisteredIds] = useState([]);
  const [message, setMessage] = useState('');

  useEffect(() => {
    fetchEvents();
    fetchMyEvents();
  }, []);

  const fetchEvents = async () => {
    const res = await axios.get('/events');
    setEvents(res.data);
  };

  const fetchMyEvents = async () => {
    const res = await axios.get('/my-events');
    setRegisteredIds(res.data.map(ev => ev.id));
  };

  const register = async (id) => {
    try {
      await axios.post('/events/register', { event_id: id });
      setMessage('✅ Registered!');
      fetchMyEvents(); // refresh
    } catch {
      setMessage('❌ Already registered or error.');
    }
  };

  return (
    <div className="p-6 max-w-3xl mx-auto">
      <h1 className="text-2xl font-bold mb-4">Upcoming Events</h1>
      {message && <p className="mb-4 text-sm">{message}</p>}
      {events.map(event => (
        <div key={event.id} className="border rounded p-4 mb-4 shadow bg-white dark:bg-gray-800">
          <h2 className="text-lg font-semibold">{event.title}</h2>
          <p>Date: {new Date(event.date).toLocaleDateString()}</p>
          <p>Location: {event.location}</p>
          <button
            onClick={() => register(event.id)}
            disabled={registeredIds.includes(event.id)}
            className={`mt-2 px-4 py-2 rounded ${
              registeredIds.includes(event.id)
                ? 'bg-gray-400 cursor-not-allowed'
                : 'bg-blue-600 hover:bg-blue-700 text-white'
            }`}
          >
            {registeredIds.includes(event.id) ? 'Already Registered' : 'Register'}
          </button>
        </div>
      ))}
    </div>
  );
};

export default EventList;
