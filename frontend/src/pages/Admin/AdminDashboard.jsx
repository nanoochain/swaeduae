import React, { useEffect, useState } from 'react';
import { getAdminStats } from '../../services/api.js';

/*
 * Shows overall statistics for administrators. The `/admin/stats` route
 * returns counts for users, events, certificates and volunteer hours
 * as implemented in `admin_stats.py`【556375943329351†L5-L16】. These numbers
 * give admins a quick overview of system health.
 */
export default function AdminDashboard() {
  const [stats, setStats] = useState(null);
  useEffect(() => {
    getAdminStats()
      .then((res) => setStats(res))
      .catch((err) => console.error(err));
  }, []);
  if (!stats) return <div>Loading...</div>;
  return (
    <div>
      <h1>Admin Dashboard</h1>
      <p>Total Users: {stats.users}</p>
      <p>Total Events: {stats.events}</p>
      <p>Total Certificates: {stats.certificates}</p>
      {stats.hours !== undefined && <p>Total Volunteer Hours: {stats.hours}</p>}
    </div>
  );
}