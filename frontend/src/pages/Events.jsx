import React, { useEffect, useState } from "react";
import axios from "axios";
export default function Events() {
  const [events, setEvents] = useState([]);
  const [type, setType] = useState("");
  useEffect(() => { axios.get("/api/events").then(r => setEvents(r.data)); }, []);
  const filtered = events.filter(e => !type || e.type === type);
  return (
    <div className="max-w-4xl mx-auto p-6">
      <h1 className="text-3xl font-bold mb-6">Upcoming Events</h1>
      <div className="mb-4">
        <select className="border p-2 rounded" onChange={e => setType(e.target.value)}>
          <option value="">All Types</option>
          <option value="education">Education</option>
          <option value="health">Health</option>
          <option value="environment">Environment</option>
        </select>
      </div>
      <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
        {filtered.map(e => (
          <div key={e.id} className="bg-white rounded-xl shadow-lg p-6 relative">
            <span className="block font-bold text-lg mb-1">{e.name}</span>
            <span className="block text-gray-500 mb-2">{e.date} | {e.location}</span>
            {e.featured && <span className="absolute top-2 right-2 bg-yellow-300 text-yellow-900 text-xs px-2 rounded-full">Featured</span>}
            <p className="mb-3">{e.description}</p>
            <a href={`/events/${e.id}`} className="bg-blue-700 text-white px-4 py-1 rounded">View Details</a>
          </div>
        ))}
      </div>
    </div>
  );
}
