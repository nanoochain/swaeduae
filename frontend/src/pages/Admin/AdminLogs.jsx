import React, { useEffect, useState } from 'react';
import { getLogs } from '../../services/api.js';

/*
 * Displays recent system logs for administrators. The backend route
 * `/admin/logs` returns a list of log objects containing an ID,
 * message and timestamp【15469675107366†L87-L94】. Administrators can use
 * this page to quickly scan for errors or unusual activity. Only
 * the most recent records are returned to avoid overwhelming the UI.
 */
export default function AdminLogs() {
  const [logs, setLogs] = useState([]);
  useEffect(() => {
    getLogs()
      .then((res) => {
        const list = res.logs || res;
        setLogs(Array.isArray(list) ? list : []);
      })
      .catch((err) => console.error(err));
  }, []);
  return (
    <div>
      <h1>System Logs</h1>
      {logs.length === 0 ? (
        <p>No log entries.</p>
      ) : (
        <ul>
          {logs.map((log) => (
            <li key={log.id}>
              {log.timestamp}: {log.message}
            </li>
          ))}
        </ul>
      )}
    </div>
  );
}