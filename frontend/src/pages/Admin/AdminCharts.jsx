import React, { useEffect, useState } from "react";
import { BarChart, Bar, XAxis, YAxis, Tooltip, ResponsiveContainer, Pie, PieChart, Legend } from "recharts";
import axios from "axios";
export default function AdminCharts() {
  const [stats, setStats] = useState([]);
  useEffect(() => {
    axios.get("/api/admin/stats/history").then(res => setStats(res.data));
  }, []);
  return (
    <div className="p-8">
      <h2 className="text-2xl font-bold mb-4">Admin Analytics</h2>
      <div className="h-64 bg-white rounded-xl mb-8">
        <ResponsiveContainer width="100%" height="100%">
          <BarChart data={stats}>
            <XAxis dataKey="date"/>
            <YAxis/>
            <Tooltip/>
            <Bar dataKey="events" fill="#0070f3"/>
            <Bar dataKey="users" fill="#22c55e"/>
          </BarChart>
        </ResponsiveContainer>
      </div>
      <div className="h-64 bg-white rounded-xl">
        <ResponsiveContainer width="100%" height="100%">
          <PieChart>
            <Pie data={stats} dataKey="certificates" nameKey="date" fill="#8b5cf6" label />
            <Legend />
            <Tooltip />
          </PieChart>
        </ResponsiveContainer>
      </div>
    </div>
  );
}
