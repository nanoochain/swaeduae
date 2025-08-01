import React, { useEffect, useState } from "react";
import { getMyCertificates } from "@/services/api";
export default function Certificates() {
  const [certs, setCerts] = useState([]);
  useEffect(() => { getMyCertificates().then(setCerts); }, []);
  return (
    <div className="p-6">
      <h1 className="text-2xl font-bold mb-4">My Certificates</h1>
      <div className="grid md:grid-cols-2 gap-4">
        {certs.map(c => (
          <div key={c.id} className="p-4 bg-white dark:bg-neutral-800 rounded-xl shadow">
            <div className="font-bold">{c.event_name}</div>
            <div className="text-xs mb-1">{c.issued_at}</div>
            <a href={c.cert_url} className="btn btn-primary" target="_blank" rel="noopener noreferrer">Download</a>
          </div>
        ))}
      </div>
    </div>
  );
}
