import React from 'react';
import { BrowserRouter as Router, Routes, Route } from 'react-router-dom';
import AdminSendCertificate from "./pages/Certificate/AdminSendCertificate";
import AdminPayments from './pages/Admin/AdminPayments';
import PaymentForm from './pages/Payment/PaymentForm';
import AdminKYC from './pages/Admin/AdminKYC';
import KYCUpload from './pages/KYC/KYCUpload';
import VerifyCertificate from "./pages/Certificate/VerifyCertificate";
import VerifyOTP from './pages/OTP/VerifyOTP';
import Login from './pages/Login';
import Signup from './pages/Signup';
import AdminCertificateVerify from "./pages/Admin/AdminCertificateVerify";
import AdminLogs from "./pages/Admin/AdminLogs";
import SystemMonitor from "./pages/Admin/SystemMonitor";
import Dashboard from './pages/Dashboard';
import AdminDashboard from './pages/Admin/AdminDashboard';
import AdminUserList from './pages/Admin/AdminUserList';
import AdminCertificateControl from './pages/Admin/AdminCertificateControl';
import AdminSystemLogs from './pages/Admin/AdminSystemLogs';
import AdminSystemStatus from './pages/Admin/AdminSystemStatus';

function App() {
  return (
    <Router>
      <Routes>
        <Route path="/kyc-upload" element={<KYCUpload />} />
        <Route path="/verify-otp" element={<VerifyOTP />} />
        <Route path="/payment" element={<PaymentForm />} />
        <Route path="/admin/kyc" element={<AdminKYC />} />
        <Route path="/admin/payments" element={<AdminPayments />} />
        <Route path="/admin/send-certificate" element={<AdminSendCertificate />} />
        <Route path="/verify-certificate" element={<VerifyCertificate />} />
        <Route path="/payment" element={<PaymentForm />} />
        <Route path="/" element={<Login />} />
        <Route path="/signup" element={<Signup />} />
        <Route path="/dashboard" element={<Dashboard />} />
        <Route path="/admin" element={<AdminDashboard />} />
        <Route path="/admin/users" element={<AdminUserList />} />
        <Route path="/admin/certificates" element={<AdminCertificateControl />} />
        <Route path="/admin/logs" element={<AdminSystemLogs />} />
        <Route path="/admin/status" element={<AdminSystemStatus />} />
      </Routes>
    </Router>
  );
}

export default App;
