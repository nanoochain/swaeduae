import React, { useEffect, useState } from "react";
import { getCertificates, sendCertificate } from "@/services/api";
export default function AdminCertificates() {
  const [certs, setCerts] = useState([]);
  useEffect(() => { getCertificates().then(setCerts); }, []);
  return (
    <div className="p-6">
      <h1 className="text-2xl font-bold mb-4">Certificates</h1>
      <table className="min-w-full text-sm">
        <thead>
          <tr className="bg-neutral-100 dark:bg-neutral-800">
            <th>ID</th><th>User</th><th>Event</th><th>Issued At</th><th>Actions</th>
          </tr>
        </thead>
        <tbody>
          {certs.map(c => (
            <tr key={c.id}>
              <td>{c.id}</td>
              <td>{c.user_email}</td>
              <td>{c.event_name}</td>
              <td>{c.issued_at}</td>
              <td>
                <a href={c.cert_url} className="btn btn-sm btn-info" target="_blank" rel="noopener noreferrer">View</a>
                <button className="btn btn-success ml-2" onClick={() => sendCertificate(c.id)}>Send</button>
              </td>
            </tr>
          ))}
        </tbody>
      </table>
    </div>
  );
}
