import React, { createContext, useContext, useEffect, useState } from 'react';
import {
  login as apiLogin,
  signup as apiSignup,
  getProfile,
} from '../services/api.js';

/*
 * AuthContext maintains the authenticated user and exposes helper methods
 * for logging in, signing up and logging out. When the provider mounts
 * it checks for an existing token in localStorage and, if present,
 * fetches the current profile from the backend. This ensures that
 * refreshing the page will keep the user logged in. All API methods
 * automatically attach the bearer token via the request helper in
 * `services/api.js`.
 */
const AuthContext = createContext();

export const useAuth = () => useContext(AuthContext);

export const AuthProvider = ({ children }) => {
  const [user, setUser] = useState(null);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    // Attempt to load the current user's profile if a token exists.
    const initialise = async () => {
      const token = localStorage.getItem('token');
      if (token) {
        try {
          const profile = await getProfile();
          // The profile endpoint may wrap the user in a `user` key or return
          // the user object directly. Accommodate both cases.
          setUser(profile.user || profile);
        } catch (err) {
          console.error('Failed to fetch profile', err);
          localStorage.removeItem('token');
        }
      }
      setLoading(false);
    };
    initialise();
  }, []);

  // Authenticate the user and save the token. Afterwards fetch the profile
  // so that we have access to role information (e.g. admin vs volunteer).
  const login = async (email, password) => {
    const res = await apiLogin(email, password);
    localStorage.setItem('token', res.token);
    const profile = await getProfile();
    setUser(profile.user || profile);
  };

  const signup = async (username, email, password) => {
    const res = await apiSignup(username, email, password);
    localStorage.setItem('token', res.token);
    const profile = await getProfile();
    setUser(profile.user || profile);
  };

  const logout = () => {
    localStorage.removeItem('token');
    setUser(null);
  };

  return (
    <AuthContext.Provider value={{ user, login, signup, logout, loading }}>
      {children}
    </AuthContext.Provider>
  );
};