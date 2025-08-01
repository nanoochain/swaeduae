import React, { useEffect, useState } from "react";
import { getEvents, approveEvent } from "@/services/api";
export default function AdminEventList() {
  const [events, setEvents] = useState([]);
  useEffect(() => { getEvents().then(setEvents); }, []);
  return (
    <div className="p-6">
      <h1 className="text-2xl font-bold mb-4">Events</h1>
      <div className="overflow-auto">
        <table className="min-w-full text-sm">
          <thead>
            <tr className="bg-neutral-100 dark:bg-neutral-800">
              <th>ID</th><th>Name</th><th>Org</th><th>Date</th><th>Status</th><th>Actions</th>
            </tr>
          </thead>
          <tbody>
            {events.map(e => (
              <tr key={e.id}>
                <td>{e.id}</td><td>{e.name}</td><td>{e.org_name}</td><td>{e.date}</td>
                <td>{e.status || 'pending'}</td>
                <td>
                  {e.status !== 'approved' && <button onClick={() => approveEvent(e.id)} className="btn btn-success">Approve</button>}
                </td>
              </tr>
            ))}
          </tbody>
        </table>
      </div>
    </div>
  );
}
