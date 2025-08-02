import React, { useEffect, useState } from 'react';
import { getEvents, getCertificates } from '../services/api.js';

/*
 * The user dashboard displays upcoming events and the user's existing
 * certificates. It queries the `/events` endpoint for a list of
 * available volunteer opportunities and `/certificates` for any
 * certificates already issued to the logged in user. Both endpoints
 * require a valid JWT which is attached automatically via the
 * request helper. The backend implements these routes to return
 * events and certificates respectively【15469675107366†L59-L73】【861662118637036†L41-L47】.
 */
export default function Dashboard() {
  const [events, setEvents] = useState([]);
  const [certs, setCerts] = useState([]);

  useEffect(() => {
    // Fetch events
    getEvents()
      .then((res) => {
        // the backend may return {events: [...]} or the array directly
        const list = res.events || res;
        setEvents(Array.isArray(list) ? list : []);
      })
      .catch((err) => console.error(err));
    // Fetch certificates
    getCertificates()
      .then((res) => {
        const list = res.certificates || res;
        setCerts(Array.isArray(list) ? list : []);
      })
      .catch((err) => console.error(err));
  }, []);

  return (
    <div>
      <h1>Dashboard</h1>
      <section>
        <h2>Upcoming Events</h2>
        {events.length === 0 ? (
          <p>No events available.</p>
        ) : (
          <ul>
            {events.map((ev) => (
              <li key={ev.id || ev.event_id}>
                {ev.title || ev.name} – {ev.date || ev.start_date}
              </li>
            ))}
          </ul>
        )}
      </section>
      <section>
        <h2>My Certificates</h2>
        {certs.length === 0 ? (
          <p>No certificates issued.</p>
        ) : (
          <ul>
            {certs.map((cert) => (
              <li key={cert.id}>Event {cert.event_id} – issued {cert.issued_at}</li>
            ))}
          </ul>
        )}
      </section>
    </div>
  );
}