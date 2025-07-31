#!/bin/bash
set -e

echo "🔧 Creating Certificates.jsx"
cat > src/pages/Certificates.jsx << 'EOF'
import React, { useEffect, useState } from 'react';
import axios from 'axios';

const Certificates = () => {
  const [certs, setCerts] = useState([]);

  useEffect(() => {
    const fetchCerts = async () => {
      try {
        const token = localStorage.getItem("token");
        const res = await axios.get("http://localhost:5000/certificates", {
          headers: { Authorization: `Bearer ${token}` }
        });
        setCerts(res.data.certificates || []);
      } catch (err) {
        console.error("Error fetching certificates:", err);
      }
    };

    fetchCerts();
  }, []);

  return (
    <div className="p-6">
      <h1 className="text-2xl font-bold mb-4">Certificates</h1>
      <ul className="space-y-2">
        {certs.map(cert => (
          <li key={cert.id} className="border p-4 rounded shadow">
            <p><strong>Event:</strong> {cert.event_name}</p>
            <p><strong>Date:</strong> {cert.issued_date}</p>
            <a href={cert.file_url} download className="text-blue-600 underline">Download</a>
          </li>
        ))}
      </ul>
    </div>
  );
};

export default Certificates;
EOF

echo "🔧 Creating AdminDashboard.jsx"
cat > src/pages/AdminDashboard.jsx << 'EOF'
import React, { useEffect, useState } from 'react';
import axios from 'axios';

const AdminDashboard = () => {
  const [stats, setStats] = useState({ users: 0, events: 0, certificates: 0 });

  useEffect(() => {
    const fetchStats = async () => {
      try {
        const token = localStorage.getItem("token");
        const res = await axios.get("http://localhost:5000/admin/stats", {
          headers: { Authorization: `Bearer ${token}` }
        });
        setStats(res.data || {});
      } catch (err) {
        console.error("Error fetching stats:", err);
      }
    };

    fetchStats();
  }, []);

  return (
    <div className="p-6">
      <h1 className="text-2xl font-bold mb-4">Admin Dashboard</h1>
      <div className="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div className="p-4 bg-white rounded shadow">👥 Users: {stats.users}</div>
        <div className="p-4 bg-white rounded shadow">📅 Events: {stats.events}</div>
        <div className="p-4 bg-white rounded shadow">📄 Certificates: {stats.certificates}</div>
      </div>
    </div>
  );
};

export default AdminDashboard;
EOF

echo "🔧 Updating App.jsx routes"
sed -i '/import PrivateRoute/i import Certificates from "./pages/Certificates";\nimport AdminDashboard from "./pages/AdminDashboard";' src/App.jsx
sed -i '/<Route path="\/dashboard" element={/,/<\/Route>/ a \
        <Route path="/certificates" element={<PrivateRoute><Certificates /></PrivateRoute>} />\
        <Route path="/admin" element={<AdminRoute><AdminDashboard /></AdminRoute>} />' src/App.jsx

echo "🔧 Updating Sidebar.jsx"
sed -i '/Dashboard<\/span>/a \
        </li>\n        <li>\n          <a href="/certificates" className="block px-4 py-2 hover:bg-gray-100">Certificates</a>\n        </li>\n        <li>\n          <a href="/admin" className="block px-4 py-2 hover:bg-gray-100">Admin</a>' src/Sidebar.jsx

echo "✅ Git commit & push"
git add src/pages/Certificates.jsx src/pages/AdminDashboard.jsx src/App.jsx src/Sidebar.jsx
git commit -m "Add Certificate viewer and Admin Dashboard pages"
git push

echo "✅ Done! Check your browser at http://localhost:5173/certificates or /admin"
