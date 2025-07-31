import React, { useEffect, useState } from 'react';

export default function SystemMonitor() {
  const [time, setTime] = useState(new Date().toLocaleString());

  useEffect(() => {
    const interval = setInterval(() => {
      setTime(new Date().toLocaleString());
    }, 5000);
    return () => clearInterval(interval);
  }, []);

  return (
    <div className="p-4">
      <h2 className="text-2xl font-bold mb-4">System Monitor</h2>
      <div className="bg-gray-100 p-4 rounded">
        <p><strong>Server Time:</strong> {time}</p>
        <p><strong>Status:</strong> ✅ Online</p>
        <p><strong>Version:</strong> 1.0.0</p>
        <p><strong>Memory Usage:</strong> Approx 60MB (mock)</p>
      </div>
    </div>
  );
}
