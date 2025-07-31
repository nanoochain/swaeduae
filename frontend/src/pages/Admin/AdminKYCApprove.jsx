import React, { useEffect, useState } from 'react';
import { getKYCSubmissions, approveKYCSubmission } from '@/services/api';

export default function AdminKYCApprove() {
  const [kycs, setKycs] = useState([]);
  const [loading, setLoading] = useState(true);
  const [message, setMessage] = useState('');

  useEffect(() => {
    fetchKycs();
  }, []);

  async function fetchKycs() {
    setLoading(true);
    try {
      const data = await getKYCSubmissions();
      setKycs(data.kyc_submissions || data);
    } catch (err) {
      setMessage('Failed to load KYC submissions');
    }
    setLoading(false);
  }

  async function handleApprove(kyc_id) {
    try {
      await approveKYCSubmission(kyc_id);
      setMessage('KYC approved!');
      fetchKycs();
    } catch (err) {
      setMessage('Failed to approve KYC');
    }
  }

  return (
    <div>
      <h2 className="text-xl font-bold mb-4">KYC Submissions</h2>
      {message && <div className="mb-2 text-green-600">{message}</div>}
      {loading ? (
        <div>Loading...</div>
      ) : (
        <table className="min-w-full border text-sm">
          <thead>
            <tr>
              <th className="border p-2">User</th>
              <th className="border p-2">Document</th>
              <th className="border p-2">Status</th>
              <th className="border p-2">Actions</th>
            </tr>
          </thead>
          <tbody>
            {kycs.map(kyc => (
              <tr key={kyc.id}>
                <td className="border p-2">{kyc.user_id}</td>
                <td className="border p-2">
                  <a href={kyc.document_url} target="_blank" rel="noopener noreferrer" className="text-blue-600 underline">
                    View
                  </a>
                </td>
                <td className="border p-2">{kyc.status}</td>
                <td className="border p-2">
                  {kyc.status === 'pending' && (
                    <button
                      className="bg-green-500 text-white px-2 py-1 rounded"
                      onClick={() => handleApprove(kyc.id)}
                    >
                      Approve
                    </button>
                  )}
                </td>
              </tr>
            ))}
          </tbody>
        </table>
      )}
    </div>
  );
}
