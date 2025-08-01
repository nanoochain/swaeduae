import React, { useEffect, useRef, useState } from "react";
import axios from "axios";

const GOOGLE_MAPS_API_KEY = "YOUR_GOOGLE_MAPS_API_KEY"; // Replace with your actual key

export default function MapEvents() {
  const mapRef = useRef(null);
  const [events, setEvents] = useState([]);

  useEffect(() => {
    axios.get("/api/events").then(res => setEvents(res.data));
  }, []);

  useEffect(() => {
    if (!window.google) {
      const script = document.createElement("script");
      script.src = \`https://maps.googleapis.com/maps/api/js?key=\${GOOGLE_MAPS_API_KEY}\`;
      script.async = true;
      script.onload = () => initializeMap();
      document.body.appendChild(script);
    } else {
      initializeMap();
    }

    function initializeMap() {
      const map = new window.google.maps.Map(mapRef.current, {
        center: { lat: 24.466667, lng: 54.366669 },
        zoom: 7,
      });
      events.forEach(e => {
        const marker = new window.google.maps.Marker({
          position: { lat: e.latitude, lng: e.longitude },
          map,
          title: e.title,
        });
        const info = new window.google.maps.InfoWindow({
          content: \`<div><strong>\${e.title}</strong><br/>\${e.date}<br/>\${e.location}</div>\`,
        });
        marker.addListener("click", () => info.open(map, marker));
      });
    }
    // eslint-disable-next-line
  }, [events]);

  return (
    <div className="p-4">
      <h1 className="text-2xl font-bold mb-4">Find Volunteer Events Near You</h1>
      <div ref={mapRef} style={{ width: "100%", height: "500px", borderRadius: "16px", overflow: "hidden" }} />
      <p className="mt-4 text-gray-600">Click on the map markers to see upcoming events.</p>
    </div>
  );
}
