import React, { useEffect, useState } from 'react';
import { getDeliveryLogs } from '@/services/api';

export default function DeliveryLogs() {
  const [logs, setLogs] = useState([]);
  useEffect(() => {
    getDeliveryLogs().then(setLogs);
  }, []);
  return (
    <div>
      <h2>Certificate Delivery Logs</h2>
      <table>
        <thead>
          <tr>
            <th>Cert ID</th>
            <th>User ID</th>
            <th>Via</th>
            <th>Status</th>
            <th>Time</th>
          </tr>
        </thead>
        <tbody>
          {logs.map(l => (
            <tr key={l.id}>
              <td>{l.cert_id}</td>
              <td>{l.user_id}</td>
              <td>{l.delivered_via}</td>
              <td>{l.status}</td>
              <td>{l.timestamp}</td>
            </tr>
          ))}
        </tbody>
      </table>
    </div>
  );
}
