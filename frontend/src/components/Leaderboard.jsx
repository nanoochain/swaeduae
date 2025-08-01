import React from "react";
export default function Leaderboard({ topUsers }) {
  return (
    <div className="max-w-2xl mx-auto bg-white rounded-xl shadow-lg p-6 mt-8">
      <h2 className="font-bold text-2xl mb-4 text-blue-800">Top Volunteers</h2>
      <ol className="list-decimal ml-6">
        {topUsers.map((u, i) => (
          <li key={u.id} className="flex items-center gap-2 mb-2">
            <span className="text-lg font-bold">{u.username}</span>
            <span className="text-sm text-gray-600">({u.hours} hrs)</span>
            {i === 0 && <span className="ml-2 text-yellow-400 text-xl">🏆</span>}
            {i === 1 && <span className="ml-2 text-gray-400 text-xl">🥈</span>}
            {i === 2 && <span className="ml-2 text-orange-800 text-xl">🥉</span>}
          </li>
        ))}
      </ol>
    </div>
  );
}
