import React, { useEffect, useState } from "react";
import { getEventVolunteers, approveVolunteerForEvent } from "@/services/api";

export default function AdminEventVolunteers() {
  const [eventId, setEventId] = useState("");
  const [vols, setVols] = useState([]);
  const [status, setStatus] = useState("");

  const handleFetch = async () => {
    if (eventId) setVols(await getEventVolunteers(eventId));
  };

  const handleApprove = async (userId) => {
    await approveVolunteerForEvent(eventId, userId);
    setStatus("Approved!");
    setVols(await getEventVolunteers(eventId));
  };

  return (
    <div className="bg-white shadow rounded p-4 mt-4">
      <h2 className="font-bold mb-2">Approve Event Volunteers</h2>
      <input
        className="input mb-2"
        placeholder="Event ID"
        value={eventId}
        onChange={e => setEventId(e.target.value)}
      />
      <button className="btn btn-secondary mb-2" onClick={handleFetch}>Load Volunteers</button>
      {status && <div className="text-green-600">{status}</div>}
      <table className="table-auto text-sm w-full">
        <thead>
          <tr><th>User</th><th>Status</th><th>Approve</th></tr>
        </thead>
        <tbody>
          {vols.map(v => (
            <tr key={v.id}>
              <td>{v.user_email}</td>
              <td>{v.status}</td>
              <td>
                {v.status !== "approved" && (
                  <button className="btn btn-primary btn-xs" onClick={() => handleApprove(v.user_id)}>
                    Approve
                  </button>
                )}
              </td>
            </tr>
          ))}
        </tbody>
      </table>
    </div>
  );
}
