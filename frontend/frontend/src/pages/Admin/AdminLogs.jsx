import React from 'react';

export default function AdminLogs() {
  const logs = [
    { time: '2025-07-31 02:00', action: 'User registered: john@example.com' },
    { time: '2025-07-31 02:15', action: 'Event created: Beach Cleanup' },
    { time: '2025-07-31 03:00', action: 'Certificate sent to jane@example.com' }
  ];

  return (
    <div className="p-4">
      <h2 className="text-2xl font-bold mb-4">System Logs</h2>
      <ul className="space-y-2">
        {logs.map((log, i) => (
          <li key={i} className="bg-gray-100 p-2 rounded">
            <strong>{log.time}</strong>: {log.action}
          </li>
        ))}
      </ul>
    </div>
  );
}
