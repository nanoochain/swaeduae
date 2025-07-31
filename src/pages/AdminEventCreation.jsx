// AdminEventCreation.jsx
import React, { useState } from 'react';
import axios from 'axios';

const AdminEventCreation = () => {
  const [title, setTitle] = useState('');
  const [date, setDate] = useState('');
  const [location, setLocation] = useState('');
  const [message, setMessage] = useState('');

  const handleCreate = async (e) => {
    e.preventDefault();
    try {
      await axios.post('/events', { title, date, location });
      setMessage('✅ Event created successfully!');
      setTitle('');
      setDate('');
      setLocation('');
    } catch (err) {
      setMessage('❌ Failed to create event.');
    }
  };

  return (
    <div className="p-6 max-w-lg mx-auto">
      <h1 className="text-2xl font-bold mb-4">Create New Event</h1>
      <form onSubmit={handleCreate} className="space-y-4">
        <input
          type="text"
          placeholder="Event Title"
          className="w-full p-2 border rounded"
          value={title}
          onChange={(e) => setTitle(e.target.value)}
          required
        />
        <input
          type="date"
          className="w-full p-2 border rounded"
          value={date}
          onChange={(e) => setDate(e.target.value)}
          required
        />
        <input
          type="text"
          placeholder="Location"
          className="w-full p-2 border rounded"
          value={location}
          onChange={(e) => setLocation(e.target.value)}
          required
        />
        <button
          type="submit"
          className="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700"
        >
          Create Event
        </button>
        {message && <p className="text-sm">{message}</p>}
      </form>
    </div>
  );
};

export default AdminEventCreation;
