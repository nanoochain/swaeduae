import React, { useEffect, useState } from 'react';
import { getUsers } from '@/services/api';

const AdminUserList = () => {
  const [users, setUsers] = useState([]);

  useEffect(() => {
    getUsers().then(setUsers);
  }, []);

  return (
    <div className="p-4">
      <h1 className="text-2xl font-bold mb-4">👥 Manage Users</h1>
      <table className="min-w-full bg-white dark:bg-gray-800 rounded-xl shadow">
        <thead>
          <tr>
            <th className="p-2">Username</th>
            <th className="p-2">Email</th>
            <th className="p-2">Role</th>
          </tr>
        </thead>
        <tbody>
          {users.map(u => (
            <tr key={u.id} className="border-t">
              <td className="p-2">{u.username}</td>
              <td className="p-2">{u.email}</td>
              <td className="p-2">{u.role}</td>
            </tr>
          ))}
        </tbody>
      </table>
    </div>
  );
};

export default AdminUserList;
