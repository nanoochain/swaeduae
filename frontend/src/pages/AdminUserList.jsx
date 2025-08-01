import React, { useEffect, useState } from "react";
import { getUsers, approveUser, banUser } from "@/services/api";
export default function AdminUserList() {
  const [users, setUsers] = useState([]);
  useEffect(() => { getUsers().then(setUsers); }, []);
  const handleApprove = async (id) => { await approveUser(id); getUsers().then(setUsers); };
  const handleBan = async (id) => { await banUser(id); getUsers().then(setUsers); };
  return (
    <div className="p-6">
      <h1 className="text-2xl font-bold mb-4">Users</h1>
      <div className="overflow-auto">
        <table className="min-w-full text-sm">
          <thead>
            <tr className="bg-neutral-100 dark:bg-neutral-800">
              <th>ID</th><th>Name</th><th>Email</th><th>Role</th><th>Status</th><th>Actions</th>
            </tr>
          </thead>
          <tbody>
            {users.map(u => (
              <tr key={u.id}>
                <td>{u.id}</td><td>{u.username}</td><td>{u.email}</td>
                <td>{u.role}</td>
                <td>{u.status || 'active'}</td>
                <td className="flex gap-2">
                  {u.status !== 'approved' && <button onClick={() => handleApprove(u.id)} className="btn btn-success">Approve</button>}
                  <button onClick={() => handleBan(u.id)} className="btn btn-error">Ban</button>
                </td>
              </tr>
            ))}
          </tbody>
        </table>
      </div>
    </div>
  );
}
