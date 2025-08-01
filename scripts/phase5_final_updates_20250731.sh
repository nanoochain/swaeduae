
cd /opt/swaeduae/frontend/src/pages/Admin
nano AdminCertificateControl.jsx << 'EOF'
import React from 'react';

const AdminCertificateControl = () => {
  return (
    <div className="p-6">
      <h1 className="text-xl font-bold mb-4">Certificate Control Panel</h1>
      <p>Here admin can approve, reject, or revoke certificates.</p>
    </div>
  );
};

export default AdminCertificateControl;
EOF

cd /opt/swaeduae/frontend/src/pages/Admin
nano AdminKYCApprove.jsx << 'EOF'
import React, { useEffect, useState } from 'react';
import { getKYCSubmissions, approveKYCSubmission } from '@/services/api';

const AdminKYCApprove = () => {
  const [submissions, setSubmissions] = useState([]);

  useEffect(() => {
    getKYCSubmissions().then(setSubmissions);
  }, []);

  const handleApprove = async (id) => {
    await approveKYCSubmission(id);
    setSubmissions(submissions.filter((s) => s.id !== id));
  };

  return (
    <div className="p-4">
      <h2 className="text-lg font-bold mb-2">KYC Approvals</h2>
      <ul>
        {submissions.map((s) => (
          <li key={s.id} className="border p-2 my-2 flex justify-between">
            <span>{s.name}</span>
            <button onClick={() => handleApprove(s.id)} className="bg-green-500 text-white px-3 py-1 rounded">
              Approve
            </button>
          </li>
        ))}
      </ul>
    </div>
  );
};

export default AdminKYCApprove;
EOF
