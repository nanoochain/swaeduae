import React, { useEffect, useState } from "react";
import axios from "axios";

export default function AdminUserList() {
  const [users, setUsers] = useState([]);
  const [search, setSearch] = useState("");
  const [selected, setSelected] = useState([]);
  useEffect(() => {
    fetchUsers();
  }, []);
  function fetchUsers(q = "") {
    axios.get("/api/admin/users", { params: { search: q } })
      .then(res => setUsers(res.data));
  }
  function handleBulk(action) {
    axios.post("/api/admin/users/bulk", { action, user_ids: selected })
      .then(() => fetchUsers());
  }
  return (
    <div className="p-8">
      <h1 className="text-2xl font-bold mb-6">Users</h1>
      <input
        className="border p-2 rounded mb-4"
        placeholder="Search users..."
        value={search}
        onChange={e => { setSearch(e.target.value); fetchUsers(e.target.value); }}
      />
      <div className="mb-4">
        <button className="bg-green-600 text-white px-3 py-1 rounded mr-2" onClick={() => handleBulk("approve")}>Approve</button>
        <button className="bg-yellow-600 text-white px-3 py-1 rounded mr-2" onClick={() => handleBulk("suspend")}>Suspend</button>
        <button className="bg-blue-600 text-white px-3 py-1 rounded mr-2" onClick={() => handleBulk("admin")}>Make Admin</button>
        <button className="bg-gray-600 text-white px-3 py-1 rounded mr-2" onClick={() => handleBulk("user")}>Remove Admin</button>
        <button className="bg-purple-600 text-white px-3 py-1 rounded" onClick={() => handleBulk("export")}>Export</button>
      </div>
      <table className="w-full bg-white rounded shadow">
        <thead>
          <tr>
            <th><input type="checkbox" onChange={e => setSelected(e.target.checked ? users.map(u => u.id) : [])} /></th>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Role</th>
            <th>Active</th>
            <th>Approved</th>
          </tr>
        </thead>
        <tbody>
          {users.map(u => (
            <tr key={u.id}>
              <td><input type="checkbox" checked={selected.includes(u.id)} onChange={e => setSelected(
                e.target.checked ? [...selected, u.id] : selected.filter(id => id !== u.id)
              )} /></td>
              <td>{u.id}</td>
              <td>{u.username}</td>
              <td>{u.email}</td>
              <td>{u.role}</td>
              <td>{u.is_active ? "Yes" : "No"}</td>
              <td>{u.is_approved ? "Yes" : "No"}</td>
            </tr>
          ))}
        </tbody>
      </table>
    </div>
  );
}
