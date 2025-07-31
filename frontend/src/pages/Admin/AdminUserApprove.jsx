import React, { useEffect, useState } from 'react';
import { getUsers, approveUser } from '@/services/api';

export default function AdminUserApprove() {
  const [users, setUsers] = useState([]);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    getUsers()
      .then((data) => setUsers(data))
      .finally(() => setLoading(false));
  }, []);

  const handleApprove = async (user_id) => {
    await approveUser(user_id);
    // Reload users after approval
    const updated = await getUsers();
    setUsers(updated);
  };

  if (loading) return <div>Loading...</div>;

  return (
    <div>
      <h2>Pending User Approvals</h2>
      <ul>
        {users.map((user) => (
          <li key={user.id}>
            {user.username} ({user.status})
            {user.status !== 'approved' && (
              <button onClick={() => handleApprove(user.id)}>Approve</button>
            )}
          </li>
        ))}
      </ul>
    </div>
  );
}
