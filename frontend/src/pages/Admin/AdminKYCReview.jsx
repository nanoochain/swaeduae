import React, { useEffect, useState } from 'react';
import { getKYCSubmissions, updateKYCSubmission } from '../../services/api.js';

/*
 * Administrators can review KYC submissions using this page. The list of
 * submissions comes from the `/admin/kyc_submissions` endpoint
 *【15469675107366†L7-L19】. Each record includes a user identifier,
 * document URL and current status. Admins may approve or reject
 * submissions by sending a POST request with the new status to
 * `/admin/kyc_submissions/<id>`【15469675107366†L21-L32】. The table updates
 * immediately after the action succeeds.
 */
export default function AdminKYCReview() {
  const [submissions, setSubmissions] = useState([]);
  useEffect(() => {
    getKYCSubmissions()
      .then((res) => {
        const list = res.kyc_submissions || res;
        setSubmissions(Array.isArray(list) ? list : []);
      })
      .catch((err) => console.error(err));
  }, []);
  const handleUpdate = async (id, status) => {
    try {
      await updateKYCSubmission(id, status);
      setSubmissions((subs) =>
        subs.map((s) => (s.id === id ? { ...s, status } : s)),
      );
    } catch (err) {
      console.error(err);
    }
  };
  return (
    <div>
      <h1>KYC Submissions</h1>
      {submissions.length === 0 ? (
        <p>No submissions pending review.</p>
      ) : (
        <table>
          <thead>
            <tr>
              <th>ID</th>
              <th>User ID</th>
              <th>Status</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            {submissions.map((s) => (
              <tr key={s.id}>
                <td>{s.id}</td>
                <td>{s.user_id}</td>
                <td>{s.status}</td>
                <td>
                  <button
                    disabled={s.status === 'approved'}
                    onClick={() => handleUpdate(s.id, 'approved')}
                  >
                    Approve
                  </button>
                  <button
                    disabled={s.status === 'rejected'}
                    onClick={() => handleUpdate(s.id, 'rejected')}
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