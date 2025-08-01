import React, { useEffect, useState } from "react";
import { getAdminLogs } from "@/services/api";
export default function AdminLogs() {
  const [logs, setLogs] = useState([]);
  useEffect(() => { getAdminLogs().then(setLogs); }, []);
  return (
    <div className="p-6">
      <h1 className="text-2xl font-bold mb-4">System Logs</h1>
      <div className="bg-white dark:bg-neutral-800 rounded-xl p-4 shadow">
        <ul className="space-y-1 text-xs">
          {logs.map(log => (
            <li key={log.id} className="border-b border-neutral-100 py-1">{log.message}</li>
          ))}
        </ul>
      </div>
    </div>
  );
}
