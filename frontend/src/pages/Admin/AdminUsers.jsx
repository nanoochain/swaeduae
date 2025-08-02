import React, { useEffect, useState } from 'react';
import { getUsers } from '../../services/api.js';

/*
 * Allows administrators to view a list of registered users. The
 * `/admin/users` endpoint should return an array of user objects
 * containing identifiers, usernames/emails and roles. If the backend
 * doesn't yet expose this route it can be implemented similarly to
 * other admin listing routes (e.g. kyc_submissions) by querying
 * the `User` model and serialising the results.
 */
export default function AdminUsers() {
  const [users, setUsers] = useState([]);
  useEffect(() => {
    getUsers()
      .then((res) => {
        const list = res.users || res;
        setUsers(Array.isArray(list) ? list : []);
      })
      .catch((err) => console.error(err));
  }, []);
  return (
    <div>
      <h1>User Management</h1>
      {users.length === 0 ? (
        <p>No users found.</p>
      ) : (
        <table>
          <thead>
            <tr>
              <th>ID</th>
              <th>Name</th>
              <th>Email</th>
              <th>Role</th>
            </tr>
          </thead>
          <tbody>
            {users.map((u) => (
              <tr key={u.id}>
                <td>{u.id}</td>
                <td>{u.username || u.name}</td>
                <td>{u.email}</td>
                <td>{u.role}</td>
              </tr>
            ))}
          </tbody>
        </table>
      )}
    </div>
  );
}