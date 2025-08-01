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
