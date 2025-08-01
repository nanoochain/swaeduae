import React from 'react';
import { BrowserRouter, Routes, Route } from 'react-router-dom';
import Home from './pages/Home';
import EventList from './pages/EventList';
import AdminDashboard from './pages/AdminDashboard';

function App() {
  return (
    <BrowserRouter>
      <Routes>
        <Route path="/" element={<Home />} />
        <Route path="/events" element={<EventList />} />
        <Route path="/admin" element={<AdminDashboard />} />
      </Routes>
    </BrowserRouter>
  );
}

export default App;

import KYCUpload from './pages/KYCUpload';
import AdminKYCReview from './pages/AdminKYCReview';

// Inside your <Routes> add:
{/* <Route path="/kyc/upload" element={<KYCUpload />} /> */}
{/* <Route path="/admin/kyc" element={<AdminKYCReview />} /> */}
