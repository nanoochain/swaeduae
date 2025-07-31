// VolunteerProfile.jsx
import React from 'react';
import { useAuth } from '../context/AuthContext';

const VolunteerProfile = () => {
  const { user } = useAuth();

  return (
    <div className="max-w-xl mx-auto p-6 bg-white shadow rounded">
      <h1 className="text-2xl font-bold mb-4">Volunteer Profile</h1>
      {user ? (
        <div className="space-y-3">
          <p><strong>Full Name:</strong> {user.username}</p>
          <p><strong>Email:</strong> {user.email}</p>
          <p><strong>Volunteer ID:</strong> {user.id}</p>
        </div>
      ) : (
        <p>Loading volunteer info...</p>
      )}
    </div>
  );
};

export default VolunteerProfile;
