import React from 'react';
import { NavLink } from 'react-router-dom';
import { useAuth } from '../context/AuthContext.jsx';

/*
 * Sidebar shows navigation links tailored to the logged in user's role. Volunteers
 * and regular users see links to their dashboard, profile, KYC upload and
 * certificate pages. Administrators additionally see links for managing
 * users, reviewing KYC submissions, volunteer approvals, certificates
 * and viewing system logs. A logout button is always available. The
 * component hides itself entirely when no user is logged in (e.g. on
 * the login or signup pages).
 */
const Sidebar = () => {
  const { user, logout } = useAuth();
  if (!user) return null;
  return (
    <aside className="sidebar" style={{ padding: '1rem', borderRight: '1px solid #eee' }}>
      <nav>
        <ul style={{ listStyle: 'none', padding: 0 }}>
          <li><NavLink to="/dashboard">Dashboard</NavLink></li>
          <li><NavLink to="/profile">Profile</NavLink></li>
          <li><NavLink to="/kyc/upload">KYC Upload</NavLink></li>
          <li><NavLink to="/certificates">My Certificates</NavLink></li>
          {user.role === 'admin' && (
            <>
              <li><NavLink to="/admin">Admin Dashboard</NavLink></li>
              <li><NavLink to="/admin/users">User Management</NavLink></li>
              <li><NavLink to="/admin/kyc">KYC Review</NavLink></li>
              <li><NavLink to="/admin/volunteer-approvals">Volunteer Approvals</NavLink></li>
              <li><NavLink to="/admin/certificates">Certificates</NavLink></li>
              <li><NavLink to="/admin/logs">System Logs</NavLink></li>
            </>
          )}
          <li><button type="button" onClick={logout}>Logout</button></li>
        </ul>
      </nav>
    </aside>
  );
};

export default Sidebar;