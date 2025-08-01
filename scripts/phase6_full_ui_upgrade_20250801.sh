#!/bin/bash
echo "🚀 Starting Phase 6 Full UI/UX Upgrade..."

cd /opt/swaeduae/frontend/src

# 🌐 Navbar
mkdir -p components layout
cat << 'EOF' > components/Navbar.jsx
import React from 'react';
import { Link } from 'react-router-dom';
export default function Navbar() {
  return (
    <nav className="bg-white border-b shadow p-4 flex justify-between items-center">
      <div className="text-2xl font-bold text-primary">SawaedUAE</div>
      <div className="space-x-4">
        <Link to="/dashboard" className="hover:underline">Dashboard</Link>
        <Link to="/events" className="hover:underline">Events</Link>
        <Link to="/certificates" className="hover:underline">Certificates</Link>
        <Link to="/profile" className="hover:underline">Profile</Link>
        <Link to="/admin" className="hover:underline">Admin</Link>
      </div>
    </nav>
  );
}
EOF

# 🎨 Global Styling
mkdir -p /opt/swaeduae/frontend/src/styles
cat << 'EOF' > /opt/swaeduae/frontend/src/styles/global.css
@tailwind base;
@tailwind components;
@tailwind utilities;

body {
  font-family: 'Noto Sans Arabic', sans-serif;
  background-color: #f9f9f9;
  color: #111827;
}
.navbar {
  background-color: #fff;
  border-bottom: 1px solid #e5e7eb;
}
.rtl {
  direction: rtl;
}
EOF

# 📦 Update App.jsx
cat << 'EOF' > App.jsx
import React from 'react';
import { Routes, Route } from 'react-router-dom';
import Navbar from './components/Navbar';
import Dashboard from './pages/Dashboard';
import Events from './pages/Events';
import Certificates from './pages/Certificates';
import Profile from './pages/Profile';
import AdminDashboard from './pages/Admin/AdminDashboard';
import './styles/global.css';

export default function App() {
  return (
    <div className="min-h-screen">
      <Navbar />
      <main className="p-4">
        <Routes>
          <Route path="/dashboard" element={<Dashboard />} />
          <Route path="/events" element={<Events />} />
          <Route path="/certificates" element={<Certificates />} />
          <Route path="/profile" element={<Profile />} />
          <Route path="/admin/*" element={<AdminDashboard />} />
        </Routes>
      </main>
    </div>
  );
}
EOF

# ✅ Footer (optional)
cat << 'EOF' > components/Footer.jsx
import React from 'react';
export default function Footer() {
  return (
    <footer className="text-center text-sm p-4 border-t mt-10 text-gray-500">
      &copy; 2025 Sawaed UAE. All rights reserved.
    </footer>
  );
}
EOF

echo "✅ UI/UX components created: Navbar, App.jsx, global.css, Footer"
echo "🎯 Ready to build and deploy"
