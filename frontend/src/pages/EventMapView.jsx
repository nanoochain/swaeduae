import React, { useEffect, useState } from 'react';

export default function EventMapView() {
  const [events, setEvents] = useState([]);

  useEffect(() => {
    // TODO: Fetch events with lat/lng from backend
    setEvents([
      { id: 1, name: 'Beach Cleanup', lat: 25.276987, lng: 55.296249 },
      { id: 2, name: 'Food Drive', lat: 25.204849, lng: 55.270783 },
    ]);
  }, []);

  return (
    <div>
      <h2>Events Map View</h2>
      <div id="map" style={{ height: '400px', width: '100%' }}>
        {/* TODO: Embed Google Maps or Leaflet here */}
        Map placeholder - integrate Google Maps API or Leaflet for markers
      </div>
      <ul>
        {events.map(e => (
          <li key={e.id}>{e.name} - ({e.lat.toFixed(3)}, {e.lng.toFixed(3)})</li>
        ))}
      </ul>
    </div>
  );
}
