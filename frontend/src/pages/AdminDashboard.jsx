// AdminDashboard.jsx
import React, { useEffect, useState } from 'react';
import axios from 'axios';

const AdminDashboard = () => {
  const [stats, setStats] = useState({ users: 0, events: 0, certificates: 0 });

  useEffect(() => {
    const fetchStats = async () => {
      try {
        const res = await axios.get('/admin/stats'); // adjust path if needed
        setStats(res.data);
      } catch (err) {
        console.error('Failed to load admin stats', err);
      }
    };
    fetchStats();
  }, []);

  return (
    <div className="p-6">
      <h1 className="text-2xl font-bold mb-6">Admin Dashboard</h1>
      <div className="grid grid-cols-1 sm:grid-cols-3 gap-6">
        <div className="bg-white dark:bg-gray-800 rounded shadow p-4">
          <h2 className="text-lg font-semibold">Total Users</h2>
          <p className="text-3xl">{stats.users}</p>
        </div>
        <div className="bg-white dark:bg-gray-800 rounded shadow p-4">
          <h2 className="text-lg font-semibold">Events</h2>
          <p className="text-3xl">{stats.events}</p>
        </div>
        <div className="bg-white dark:bg-gray-800 rounded shadow p-4">
          <h2 className="text-lg font-semibold">Certificates</h2>
          <p className="text-3xl">{stats.certificates}</p>
        </div>
      </div>
    </div>
  );
};

export default AdminDashboard;
