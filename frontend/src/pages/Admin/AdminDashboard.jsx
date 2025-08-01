import React, { useEffect, useState } from 'react';

export default function AdminDashboard() {
  const [kycSubmissions, setKycSubmissions] = useState([]);
  const [volunteerApprovals, setVolunteerApprovals] = useState([]);
  const [certificates, setCertificates] = useState([]);
  const [logs, setLogs] = useState([]);

  const token = localStorage.getItem('token');
  const headers = { 'Authorization': 'Bearer ' + token, 'Content-Type': 'application/json' };

  const fetchKYC = async () => {
    const res = await fetch('/admin/kyc_submissions', { headers });
    const data = await res.json();
    setKycSubmissions(data.kyc_submissions);
  };

  const fetchApprovals = async () => {
    const res = await fetch('/admin/volunteer_approvals', { headers });
    const data = await res.json();
    setVolunteerApprovals(data.volunteer_approvals);
  };

  const fetchCertificates = async () => {
    const res = await fetch('/admin/certificates', { headers });
    const data = await res.json();
    setCertificates(data.certificates);
  };

  const fetchLogs = async () => {
    const res = await fetch('/admin/logs', { headers });
    const data = await res.json();
    setLogs(data.logs);
  };

  const updateStatus = async (type, id, status) => {
    const url = type === 'kyc' ? `/admin/kyc_submissions/${id}` : `/admin/volunteer_approvals/${id}`;
    const res = await fetch(url, {
      method: 'POST',
      headers,
      body: JSON.stringify({ status })
    });
    if(res.ok){
      if(type === 'kyc') fetchKYC();
      else fetchApprovals();
    }
  };

  const createCertificate = async () => {
    const user_id = prompt('Enter User ID for certificate');
    const event_id = prompt('Enter Event ID for certificate');
    if (!user_id || !event_id) return alert('User ID and Event ID required');
    const res = await fetch('/admin/certificates', {
      method: 'POST',
      headers,
      body: JSON.stringify({ user_id, event_id })
    });
    if (res.ok) {
      alert('Certificate created');
      fetchCertificates();
    } else {
      alert('Failed to create certificate');
    }
  };

  useEffect(() => {
    fetchKYC();
    fetchApprovals();
    fetchCertificates();
    fetchLogs();
  }, []);

  return (
    <div>
      <h2>KYC Submissions</h2>
      <ul>
        {kycSubmissions.map(sub => (
          <li key={sub.id}>
            User: {sub.user_id}, Status: {sub.status || 'pending'}
            <button onClick={() => updateStatus('kyc', sub.id, 'approved')}>Approve</button>
            <button onClick={() => updateStatus('kyc', sub.id, 'rejected')}>Reject</button>
          </li>
        ))}
      </ul>

      <h2>Volunteer Approvals</h2>
      <ul>
        {volunteerApprovals.map(app => (
          <li key={app.id}>
            User: {app.user_id}, Event: {app.event_id}, Status: {app.status || 'pending'}
            <button onClick={() => updateStatus('volunteer', app.id, 'approved')}>Approve</button>
            <button onClick={() => updateStatus('volunteer', app.id, 'rejected')}>Reject</button>
          </li>
        ))}
      </ul>

      <h2>Certificates</h2>
      <button onClick={createCertificate}>Create Certificate</button>
      <ul>
        {certificates.map(cert => (
          <li key={cert.id}>
            User ID: {cert.user_id}, Event ID: {cert.event_id}, Issued At: {cert.issued_at}, 
            URL: <a href={cert.cert_url} target="_blank" rel="noopener noreferrer">View</a>
          </li>
        ))}
      </ul>

      <h2>System Logs (Recent 100)</h2>
      <ul>
        {logs.map(log => (
          <li key={log.id}>
            [{log.timestamp}] {log.message}
          </li>
        ))}
      </ul>
    </div>
  );
}
