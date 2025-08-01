import React from 'react';
import { BrowserRouter as Router, Routes, Route } from 'react-router-dom';

// Import your pages/components
import Login from './pages/Login';
import Signup from './pages/Signup';
import Dashboard from './pages/Dashboard';
import AdminDashboard from './pages/Admin/AdminDashboard';
import AdminUserList from './pages/Admin/AdminUserList';
import AdminKYCApprove from './pages/Admin/AdminKYCApprove';
import AdminCertApprove from './pages/Admin/AdminCertApprove';
import AdminUserApprove from './pages/Admin/AdminUserApprove';

// NEW Certificate, Delivery Log, and Public Verification pages
import CertificateViewer from './pages/Volunteer/CertificateViewer';
import DeliveryLogs from './pages/Admin/DeliveryLogs';
import CertificateVerify from './pages/Public/CertificateVerify';

function App() {
  return (
    <Router>
      <Routes>
        {/* Public pages */}
        <Route path="/login" element={<Login />} />
        <Route path="/signup" element={<Signup />} />
        
        {/* Dashboard */}
        <Route path="/dashboard" element={<Dashboard />} />

        {/* Admin routes */}
        <Route path="/admin" element={<AdminDashboard />} />
        <Route path="/admin/users" element={<AdminUserList />} />
        <Route path="/admin/kyc-approve" element={<AdminKYCApprove />} />
        <Route path="/admin/cert-approve" element={<AdminCertApprove />} />
        <Route path="/admin/user-approve" element={<AdminUserApprove />} />
        <Route path="/admin/delivery-logs" element={<DeliveryLogs />} />

        {/* Volunteer */}
        <Route path="/volunteer/certificates" element={<CertificateViewer />} />

        {/* Public certificate verification */}
        <Route path="/verify/:certId" element={<CertificateVerify />} />

        {/* Default route */}
        <Route path="*" element={<Dashboard />} />
      </Routes>
    </Router>
  );
}

export default App;
