// Profile.jsx
import React from 'react';
import { useAuth } from '../context/AuthContext';

const Profile = () => {
  const { user } = useAuth();

  return (
    <div className="max-w-2xl mx-auto p-6 bg-white rounded shadow">
      <h1 className="text-2xl font-bold mb-4">Profile</h1>
      {user ? (
        <div className="space-y-2">
          <p><strong>Name:</strong> {user.username}</p>
          <p><strong>Email:</strong> {user.email}</p>
          <p><strong>Role:</strong> {user.role}</p>
        </div>
      ) : (
        <p>Loading user info...</p>
      )}
    </div>
  );
};

export default Profile;
