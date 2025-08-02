import React from 'react';
import { Navigate } from 'react-router-dom';
import { useAuth } from '../context/AuthContext.jsx';

/*
 * PrivateRoute restricts access to authenticated users and optionally to
 * specific roles. It waits for the AuthProvider to finish initialising
 * (loading) and then either renders the children or redirects to the
 * appropriate page. If a `roles` prop is provided it will only
 * permit access if the current user's role is included. Users with
 * insufficient privileges will be redirected to their dashboard.
 */
const PrivateRoute = ({ children, roles }) => {
  const { user, loading } = useAuth();
  if (loading) {
    return <div>Loading...</div>;
  }
  if (!user) {
    return <Navigate to="/login" replace />;
  }
  if (roles && !roles.includes(user.role)) {
    return <Navigate to="/dashboard" replace />;
  }
  return children;
};

export default PrivateRoute;