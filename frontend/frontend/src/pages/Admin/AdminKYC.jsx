import React, { useEffect, useState } from 'react';
import { getKYCSubmissions } from '../../services/api';

export default function AdminKYC() {
  const [kycList, setKycList] = useState([]);

  useEffect(() => {
    getKYCSubmissions().then(setKycList);
  }, []);

  return (
    <div className="p-4">
      <h2 className="text-2xl font-bold mb-4">KYC Submissions</h2>
      <table className="table-auto w-full">
        <thead>
          <tr><th>User</th><th>Status</th><th>Document</th></tr>
        </thead>
        <tbody>
          {kycList.map((kyc, i) => (
            <tr key={i}>
              <td>{kyc.user}</td>
              <td>{kyc.status}</td>
              <td><a href={kyc.document_url} target="_blank" rel="noreferrer">View</a></td>
            </tr>
          ))}
        </tbody>
      </table>
    </div>
  );
}
