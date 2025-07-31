import React, { useEffect, useState } from 'react';
import { useTranslation } from 'react-i18next';

const AdminDashboard = () => {
  const { t } = useTranslation();
  const [stats, setStats] = useState({ total_users: 0, total_events: 0 });

  useEffect(() => {
    const fetchStats = async () => {
      try {
        const res = await fetch('/admin/stats');
        const data = await res.json();
        if (data) setStats(data);
      } catch (err) {
        console.error('Error loading stats:', err);
      }
    };

    fetchStats();

    const socket = new WebSocket("wss://swaeduae.ae/ws/stats");
    socket.onmessage = (msg) => {
      const live = JSON.parse(msg.data);
      setStats(live);
    };

    return () => socket.close();
  }, []);

  return (
    <div className="p-4">
      <h1 className="text-2xl font-bold">{t("Sidebar.Dashboard")}</h1>
      <p><strong>Total Users:</strong> {stats.total_users}</p>
      <p><strong>Total Events:</strong> {stats.total_events}</p>
    </div>
  );
};

export default AdminDashboard;
