import React, { useEffect, useState } from 'react';
import { getProfile } from '../services/api.js';

/*
 * The profile page fetches the logged in user's details using the
 * `/profile` endpoint which requires a bearer token. The backend
 * returns information such as username, email and role. If the
 * request fails (e.g. due to an expired token) the user will be
 * logged out by the AuthProvider on the next reload.
 */
export default function Profile() {
  const [profile, setProfile] = useState(null);
  const [error, setError] = useState(null);
  useEffect(() => {
    getProfile()
      .then((res) => {
        setProfile(res.user || res);
      })
      .catch((err) => {
        console.error(err);
        setError('Failed to load profile');
      });
  }, []);
  if (error) return <div>{error}</div>;
  if (!profile) return <div>Loading...</div>;
  return (
    <div>
      <h1>Profile</h1>
      <p>Name: {profile.username || profile.name}</p>
      <p>Email: {profile.email}</p>
      <p>Role: {profile.role}</p>
    </div>
  );
}