import React, { useState } from "react";
export default function AdminAdvancedSearch({ onSearch }) {
  const [field, setField] = useState("username");
  const [query, setQuery] = useState("");
  return (
    <div className="flex gap-2 mb-4">
      <select className="border p-2 rounded" value={field} onChange={e => setField(e.target.value)}>
        <option value="username">Username</option>
        <option value="email">Email</option>
        <option value="role">Role</option>
      </select>
      <input className="border p-2 rounded" placeholder="Search..." value={query} onChange={e => setQuery(e.target.value)} />
      <button className="bg-blue-700 text-white px-4 py-2 rounded" onClick={() => onSearch(field, query)}>Search</button>
    </div>
  );
}
