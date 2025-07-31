import React, { useEffect, useState } from 'react';
import { getAdminStats } from '@/services/api';
import { PieChart, Pie, Cell, Tooltip, ResponsiveContainer } from 'recharts';

const COLORS = ['#0088FE', '#00C49F', '#FFBB28'];

const AdminDashboard = () => {
  const [stats, setStats] = useState({ users: 0, events: 0, certificates: 0 });

  useEffect(() => {
    getAdminStats().then(setStats);
  }, []);

  const data = [
    { name: 'Users', value: stats.users },
    { name: 'Events', value: stats.events },
    { name: 'Certificates', value: stats.certificates },
  ];

  return (
    <div className="p-4">
      <h1 className="text-2xl font-bold mb-4">📊 Admin Dashboard</h1>
      <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div className="bg-white dark:bg-gray-800 rounded-xl p-4 shadow">
          <h2 className="text-lg font-semibold mb-2">Total Stats</h2>
          <ul className="space-y-1">
            <li>👥 Users: {stats.users}</li>
            <li>📅 Events: {stats.events}</li>
            <li>📄 Certificates: {stats.certificates}</li>
          </ul>
        </div>
        <div className="bg-white dark:bg-gray-800 rounded-xl p-4 shadow">
          <ResponsiveContainer width="100%" height={250}>
            <PieChart>
              <Pie data={data} dataKey="value" nameKey="name" outerRadius={80} label>
                {data.map((entry, index) => (
                  <Cell key={`cell-${index}`} fill={COLORS[index % COLORS.length]} />
                ))}
              </Pie>
              <Tooltip />
            </PieChart>
          </ResponsiveContainer>
        </div>
      </div>
    </div>
  );
};

export default AdminDashboard;
