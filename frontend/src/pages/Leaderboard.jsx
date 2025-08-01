import React, { useEffect, useState } from "react";
import axios from "axios";

export default function Leaderboard() {
  const [leaders, setLeaders] = useState([]);
  useEffect(() => {
    axios.get("/api/leaderboard").then(res => setLeaders(res.data)).catch(() => setLeaders([]));
  }, []);
  return (
    <div className="p-8">
      <h1 className="text-3xl font-bold mb-6 text-purple-800">Top Volunteers</h1>
      <table className="w-full bg-white rounded-xl shadow">
        <thead>
          <tr className="bg-purple-100">
            <th className="px-4 py-2">#</th>
            <th className="px-4 py-2">Name</th>
            <th className="px-4 py-2">Hours</th>
            <th className="px-4 py-2">Events</th>
          </tr>
        </thead>
        <tbody>
          {leaders.map((u, i) => (
            <tr key={u.id} className="border-t">
              <td className="px-4 py-2">{i + 1}</td>
              <td className="px-4 py-2">{u.username}</td>
              <td className="px-4 py-2">{u.hours}</td>
              <td className="px-4 py-2">{u.events}</td>
            </tr>
          ))}
        </tbody>
      </table>
      <p className="mt-6 text-gray-500">The leaderboard celebrates the most active volunteers each month. Earn more hours to be featured!</p>
    </div>
  );
}
