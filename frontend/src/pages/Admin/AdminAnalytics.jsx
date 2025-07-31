import React, { useEffect, useState } from "react";
import { BarChart, Bar, XAxis, YAxis, Tooltip, ResponsiveContainer } from "recharts";
import { getAdminStats } from "@/services/api";

export default function AdminAnalytics() {
  const [stats, setStats] = useState({});
  useEffect(() => {
    getAdminStats().then(setStats);
  }, []);
  return (
    <div className="bg-white shadow rounded p-4">
      <h2 className="font-bold mb-2">Site Stats</h2>
      <div className="flex flex-wrap gap-4">
        <div>
          <span className="font-bold text-lg">{stats.users}</span> Users
        </div>
        <div>
          <span className="font-bold text-lg">{stats.events}</span> Events
        </div>
        <div>
          <span className="font-bold text-lg">{stats.certificates}</span> Certificates
        </div>
        <div>
          <span className="font-bold text-lg">{stats.kyc_pending}</span> KYC Pending
        </div>
      </div>
      <ResponsiveContainer width="100%" height={200}>
        <BarChart data={stats.activity || []}>
          <XAxis dataKey="date" />
          <YAxis />
          <Tooltip />
          <Bar dataKey="logins" fill="#8884d8" />
        </BarChart>
      </ResponsiveContainer>
    </div>
  );
}
