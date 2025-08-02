#!/bin/bash
echo "🚀 Starting Phase 5: Final System Controls Setup..."

echo "📁 Creating Final Admin Control Pages..."

mkdir -p src/pages/Admin

# AdminCertificateVerify.jsx
cat << 'EOF' > src/pages/Admin/AdminCertificateVerify.jsx
import React, { useState } from 'react';

export default function AdminCertificateVerify() {
  const [certId, setCertId] = useState('');
  const [result, setResult] = useState(null);

  const verifyCertificate = async () => {
    try {
      const res = await fetch(\`/certificates/verify/\${certId}\`);
      const data = await res.json();
      setResult(data);
    } catch (err) {
      setResult({ error: 'Verification failed.' });
    }
  };

  return (
    <div className="p-4">
      <h2 className="text-2xl font-bold mb-4">Verify Certificate</h2>
      <input
        type="text"
        value={certId}
        onChange={(e) => setCertId(e.target.value)}
        placeholder="Enter Certificate ID"
        className="border p-2 mr-2"
      />
      <button onClick={verifyCertificate} className="bg-blue-600 text-white px-4 py-2 rounded">
        Verify
      </button>
      {result && (
        <div className="mt-4 p-4 border bg-gray-50 rounded">
          <pre>{JSON.stringify(result, null, 2)}</pre>
        </div>
      )}
    </div>
  );
}
EOF

# AdminLogs.jsx
cat << 'EOF' > src/pages/Admin/AdminLogs.jsx
import React from 'react';

export default function AdminLogs() {
  const logs = [
    { time: '2025-07-31 02:00', action: 'User registered: john@example.com' },
    { time: '2025-07-31 02:15', action: 'Event created: Beach Cleanup' },
    { time: '2025-07-31 03:00', action: 'Certificate sent to jane@example.com' }
  ];

  return (
    <div className="p-4">
      <h2 className="text-2xl font-bold mb-4">System Logs</h2>
      <ul className="space-y-2">
        {logs.map((log, i) => (
          <li key={i} className="bg-gray-100 p-2 rounded">
            <strong>{log.time}</strong>: {log.action}
          </li>
        ))}
      </ul>
    </div>
  );
}
EOF

# SystemMonitor.jsx
cat << 'EOF' > src/pages/Admin/SystemMonitor.jsx
import React, { useEffect, useState } from 'react';

export default function SystemMonitor() {
  const [time, setTime] = useState(new Date().toLocaleString());

  useEffect(() => {
    const interval = setInterval(() => {
      setTime(new Date().toLocaleString());
    }, 5000);
    return () => clearInterval(interval);
  }, []);

  return (
    <div className="p-4">
      <h2 className="text-2xl font-bold mb-4">System Monitor</h2>
      <div className="bg-gray-100 p-4 rounded">
        <p><strong>Server Time:</strong> {time}</p>
        <p><strong>Status:</strong> ✅ Online</p>
        <p><strong>Version:</strong> 1.0.0</p>
        <p><strong>Memory Usage:</strong> Approx 60MB (mock)</p>
      </div>
    </div>
  );
}
EOF

echo "✅ Pages written: CertificateVerify, Logs, SystemMonitor"

echo "📦 Updating App.jsx with routes..."
sed -i '/import Dashboard/i\
import AdminCertificateVerify from "./pages/Admin/AdminCertificateVerify";\
import AdminLogs from "./pages/Admin/AdminLogs";\
import SystemMonitor from "./pages/Admin/SystemMonitor";
' src/App.jsx

sed -i '/<Route path="\/admin\/userlist"/a\
<Route path="/admin/verify" element={<AdminCertificateVerify />} />\
<Route path="/admin/logs" element={<AdminLogs />} />\
<Route path="/admin/monitor" element={<SystemMonitor />} />
' src/App.jsx

echo "✅ Routes updated in App.jsx"

echo "📤 Committing and pushing to GitHub..."
git add .
git commit -m "🛡️ Phase 5: Admin Controls - Verify, Logs, Monitor"
git push

echo "✅ Phase 5 Complete!"
