import React, { useEffect, useState } from 'react';
import axios from 'axios';

export default function AdminKYCReview() {
  const [submissions, setSubmissions] = useState([]);

  useEffect(() => {
    const fetchSubmissions = async () => {
      const token = localStorage.getItem('token'); // Adjust token retrieval as needed
      const res = await axios.get('/kyc/submissions', {
        headers: { Authorization: `Bearer ${token}` },
      });
      setSubmissions(res.data);
    };
    fetchSubmissions();
  }, []);

  const updateStatus = async (id, status) => {
    const token = localStorage.getItem('token');
    try {
      await axios.post(`/kyc/${status}/${id}`, {}, {
        headers: { Authorization: `Bearer ${token}` },
      });
      setSubmissions(submissions.map(s => s.id === id ? { ...s, status } : s));
    } catch (err) {
      alert('Error updating status');
    }
  };

  return (
    <div>
      <h2>KYC Submissions</h2>
      <table>
        <thead>
          <tr>
            <th>ID</th><th>User ID</th><th>Document</th><th>Status</th><th>Submitted At</th><th>Actions</th>
          </tr>
        </thead>
        <tbody>
          {submissions.map(s => (
            <tr key={s.id}>
              <td>{s.id}</td>
              <td>{s.user_id}</td>
              <td><a href={`/${s.document_url}`} target="_blank" rel="noreferrer">View</a></td>
              <td>{s.status}</td>
              <td>{new Date(s.submitted_at).toLocaleString()}</td>
              <td>
                <button onClick={() => updateStatus(s.id, 'approved')}>Approve</button>
                <button onClick={() => updateStatus(s.id, 'rejected')}>Reject</button>
              </td>
            </tr>
          ))}
        </tbody>
      </table>
    </div>
  );
}
