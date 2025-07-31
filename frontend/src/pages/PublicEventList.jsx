import React, { useEffect, useState } from "react";
import { getEvents, registerForEvent } from "@/services/api";

export default function PublicEventList() {
  const [events, setEvents] = useState([]);
  const [status, setStatus] = useState("");
  useEffect(() => {
    getEvents().then(setEvents);
  }, []);
  const handleRegister = async (eventId) => {
    await registerForEvent(eventId);
    setStatus("Registered!");
  };
  return (
    <div className="p-4">
      <h2 className="text-2xl font-bold mb-4">Volunteer Events</h2>
      {status && <div className="mb-2 text-green-600">{status}</div>}
      <div className="grid gap-4">
        {events.map(ev => (
          <div key={ev.id} className="border rounded p-4 flex flex-col md:flex-row justify-between items-center">
            <div>
              <h3 className="font-bold">{ev.title}</h3>
              <div className="text-sm text-gray-700">{ev.date}</div>
              <div>{ev.location}</div>
              <div className="text-xs">{ev.description}</div>
            </div>
            <button className="btn btn-primary mt-2 md:mt-0" onClick={() => handleRegister(ev.id)}>
              Register
            </button>
          </div>
        ))}
      </div>
    </div>
  );
}
