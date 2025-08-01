import React, { useEffect, useState } from "react";
import { getKYCSubmissions, approveKYCSubmission } from "@/services/api";
export default function AdminKYCApprove() {
  const [kycs, setKycs] = useState([]);
  useEffect(() => { getKYCSubmissions().then(setKycs); }, []);
  return (
    <div className="p-6">
      <h1 className="text-2xl font-bold mb-4">KYC Approvals</h1>
      <table className="min-w-full text-sm">
        <thead>
          <tr className="bg-neutral-100 dark:bg-neutral-800">
            <th>ID</th><th>User</th><th>Document</th><th>Status</th><th>Actions</th>
          </tr>
        </thead>
        <tbody>
          {kycs.map(k => (
            <tr key={k.id}>
              <td>{k.id}</td><td>{k.user_email}</td>
              <td><a href={k.document_url} className="text-primary-600" target="_blank" rel="noopener noreferrer">View</a></td>
              <td>{k.status}</td>
              <td>
                {k.status !== "approved" && <button className="btn btn-success" onClick={() => approveKYCSubmission(k.id)}>Approve</button>}
              </td>
            </tr>
          ))}
        </tbody>
      </table>
    </div>
  );
}
