import React, { useEffect, useState } from "react";
import axios from "axios";

export default function Analytics() {
  const [stats, setStats] = useState({});
  useEffect(() => {
    axios.get("/api/admin/stats").then(res => setStats(res.data));
  }, []);
  return (
    <div className="p-8">
      <h1 className="text-3xl font-bold mb-8 text-blue-800">Analytics & System Stats</h1>
      <div className="grid grid-cols-2 md:grid-cols-4 gap-6 mb-12">
        <div className="bg-blue-100 rounded-xl p-6 text-center">
          <div className="text-4xl font-bold">{stats.users ?? "..."}</div>
          <div className="text-lg text-blue-900">Users</div>
        </div>
        <div className="bg-green-100 rounded-xl p-6 text-center">
          <div className="text-4xl font-bold">{stats.events ?? "..."}</div>
          <div className="text-lg text-green-900">Events</div>
        </div>
        <div className="bg-purple-100 rounded-xl p-6 text-center">
          <div className="text-4xl font-bold">{stats.certificates ?? "..."}</div>
          <div className="text-lg text-purple-900">Certificates</div>
        </div>
        <div className="bg-yellow-100 rounded-xl p-6 text-center">
          <div className="text-4xl font-bold">{stats.hours ?? "..."}</div>
          <div className="text-lg text-yellow-900">Volunteer Hours</div>
        </div>
      </div>
      {/* You can add charts using recharts or chart.js if you like */}
      <div className="bg-white p-6 rounded-xl shadow text-gray-500 text-sm">
        <div>To view API documentation, visit <a href="/api/docs" className="text-blue-700 underline">/api/docs</a></div>
      </div>
    </div>
  );
}
