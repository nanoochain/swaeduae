#!/bin/bash
echo "🚀 Starting Phase 6: UI/UX Upgrade to Match Government-Grade Design..."

cd /opt/swaeduae/frontend

echo "📁 Creating upgraded layout and style files..."
mkdir -p src/layout src/styles

# Navbar/Header
cat << 'EOF' > src/layout/Navbar.jsx
import React from 'react';
import { Link } from 'react-router-dom';

export default function Navbar() {
  return (
    <nav className="bg-white shadow-md px-4 py-3 flex justify-between items-center">
      <h1 className="text-xl font-bold text-blue-800">Sawaed UAE</h1>
      <div className="space-x-4">
        <Link to="/dashboard" className="text-gray-700 hover:text-blue-600">Dashboard</Link>
        <Link to="/events" className="text-gray-700 hover:text-blue-600">Events</Link>
        <Link to="/certificates" className="text-gray-700 hover:text-blue-600">Certificates</Link>
      </div>
    </nav>
  );
}
EOF

# Global Styles
cat << 'EOF' > src/styles/global.css
body {
  font-family: 'Noto Sans Arabic', 'Helvetica Neue', sans-serif;
  background-color: #f9f9f9;
  color: #1a1a1a;
}
a {
  transition: all 0.3s ease;
}
a:hover {
  text-decoration: none;
}
EOF

# Update App.jsx to use new Navbar
cat << 'EOF' > src/App.jsx
import React from 'react';
import { Routes, Route } from 'react-router-dom';
import Navbar from './layout/Navbar';
import Dashboard from './pages/Dashboard';
import PublicEventList from './pages/PublicEventList';
import CertificateViewer from './pages/CertificateViewer';

function App() {
  return (
    <>
      <Navbar />
      <div className="p-4">
        <Routes>
          <Route path="/dashboard" element={<Dashboard />} />
          <Route path="/events" element={<PublicEventList />} />
          <Route path="/certificates" element={<CertificateViewer />} />
        </Routes>
      </div>
    </>
  );
}

export default App;
EOF

echo "✅ Phase 6 UI/UX components updated. Please rebuild frontend with: npm run build"
