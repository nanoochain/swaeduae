import React from 'react';
import { BrowserRouter, Routes, Route } from 'react-router-dom';

import VolunteerProfile from './pages/VolunteerProfile';
import EventImageUpload from './pages/EventImageUpload';
import EventMapView from './pages/EventMapView';
import VolunteerDashboard from './pages/VolunteerDashboard';
import Waitlist from './pages/Waitlist';
import CertificateReissueRequest from './pages/CertificateReissueRequest';
import AdminMultiUserOrg from './pages/AdminMultiUserOrg';
import AdminNotifications from './pages/AdminNotifications';
import FAQ from './pages/FAQ';
import SupportTickets from './pages/SupportTickets';
import NewsBlog from './pages/NewsBlog';
import PrivacyPolicy from './pages/PrivacyPolicy';
import Accessibility from './pages/Accessibility';

// Existing imports you have for admin, events, users, etc.

export default function App() {
  return (
    <BrowserRouter>
      <Routes>
        {/* Existing routes */}
        <Route path="/profile" element={<VolunteerProfile />} />
        <Route path="/event-image-upload/:eventId" element={<EventImageUpload />} />
        <Route path="/events-map" element={<EventMapView />} />
        <Route path="/dashboard" element={<VolunteerDashboard />} />
        <Route path="/waitlist" element={<Waitlist />} />
        <Route path="/certificates/reissue" element={<CertificateReissueRequest />} />
        <Route path="/admin/org-management" element={<AdminMultiUserOrg />} />
        <Route path="/admin/notifications" element={<AdminNotifications />} />
        <Route path="/faq" element={<FAQ />} />
        <Route path="/support-tickets" element={<SupportTickets />} />
        <Route path="/news" element={<NewsBlog />} />
        <Route path="/privacy" element={<PrivacyPolicy />} />
        <Route path="/accessibility" element={<Accessibility />} />
      </Routes>
    </BrowserRouter>
  );
}
