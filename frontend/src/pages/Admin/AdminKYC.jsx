import React, { useEffect, useState } from 'react';
import { getKYCSubmissions } from '@/services/api';

export default function AdminKYC() {
  const [docs, setDocs] = useState([]);
  useEffect(() => {
    getKYCSubmissions().then(setDocs);
  }, []);
  return (
    <div className="p-4">
      <h2 className="text-2xl font-bold mb-4">KYC Submissions</h2>
      <ul>{docs.map((d, i) => <li key={i}>{d.user} - <a href={d.link}>View</a></li>)}</ul>
    </div>
  );
}
