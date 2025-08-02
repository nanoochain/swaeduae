import React, { useEffect, useState } from 'react';
import { getVolunteerApprovals, updateVolunteerApproval } from '../../services/api.js';

/*
 * Displays volunteer applications awaiting approval. The backend route
 * `/admin/volunteer_approvals` returns a list of approval requests
 * containing the user and event identifiers【15469675107366†L33-L45】. An
 * administrator can change the status of an application by POSTing
 * either "approved" or "rejected" to `/admin/volunteer_approvals/<id>`
 *【15469675107366†L46-L57】. The UI updates in-place after each action.
 */
export default function AdminVolunteerApprovals() {
  const [approvals, setApprovals] = useState([]);
  useEffect(() => {
    getVolunteerApprovals()
      .then((res) => {
        const list = res.volunteer_approvals || res;
        setApprovals(Array.isArray(list) ? list : []);
      })
      .catch((err) => console.error(err));
  }, []);
  const handleUpdate = async (id, status) => {
    try {
      await updateVolunteerApproval(id, status);
      setApprovals((apps) =>
        apps.map((a) => (a.id === id ? { ...a, status } : a)),
      );
    } catch (err) {
      console.error(err);
    }
  };
  return (
    <div>
      <h1>Volunteer Approvals</h1>
      {approvals.length === 0 ? (
        <p>No volunteer applications.</p>
      ) : (
        <table>
          <thead>
            <tr>
              <th>ID</th>
              <th>User ID</th>
              <th>Event ID</th>
              <th>Status</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            {approvals.map((a) => (
              <tr key={a.id}>
                <td>{a.id}</td>
                <td>{a.user_id}</td>
                <td>{a.event_id}</td>
                <td>{a.status}</td>
                <td>
                  <button
                    disabled={a.status === 'approved'}
                    onClick={() => handleUpdate(a.id, 'approved')}
                  >
                    Approve
                  </button>
                  <button
                    disabled={a.status === 'rejected'}
                    onClick={() => handleUpdate(a.id, 'rejected')}
                  >
                    Reject
                  </button>
                </td>
              </tr>
            ))}
          </tbody>
        </table>
      )}
    </div>
  );
}