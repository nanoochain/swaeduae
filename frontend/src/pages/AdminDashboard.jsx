import React, { useEffect, useState } from 'react';

export default function AdminDashboard() {
  const [users, setUsers] = useState([]);
  const [events, setEvents] = useState([]);

  useEffect(() => {
    fetch('/admin/users')
      .then(res => res.json())
      .then(data => setUsers(data.users))
      .catch(console.error);

    fetch('/admin/events')
      .then(res => res.json())
      .then(data => setEvents(data.events))
      .catch(console.error);
  }, []);

  return (
    <div>
      <h2>Admin Dashboard</h2>
      <h3>Users</h3>
      <ul>{users.map(u => <li key={u.id}>{u.username} ({u.email})</li>)}</ul>
      <h3>Events</h3>
      <ul>{events.map(e => <li key={e.id}>{e.name}</li>)}</ul>
    </div>
  );
}
