import React, { useState } from 'react';
import { useAuth } from '../context/AuthContext.jsx';
import { Navigate, Link } from 'react-router-dom';

/*
 * Simple login form. It calls the AuthContext `login` method which in
 * turn posts credentials to the `/login` endpoint. Upon success the
 * user will be redirected to their dashboard. If already logged in
 * the component redirects immediately.
 */
export default function Login() {
  const { user, login } = useAuth();
  const [email, setEmail] = useState('');
  const [password, setPassword] = useState('');
  const [error, setError] = useState(null);
  const handleSubmit = async (e) => {
    e.preventDefault();
    try {
      await login(email, password);
    } catch (err) {
      setError('Invalid credentials');
    }
  };
  if (user) return <Navigate to="/dashboard" replace />;
  return (
    <div>
      <h1>Login</h1>
      <form onSubmit={handleSubmit}>
        <input
          type="email"
          placeholder="Email"
          value={email}
          onChange={(e) => setEmail(e.target.value)}
        />
        <input
          type="password"
          placeholder="Password"
          value={password}
          onChange={(e) => setPassword(e.target.value)}
        />
        <button type="submit">Login</button>
      </form>
      {error && <p style={{ color: 'red' }}>{error}</p>}
      <p>
        No account? <Link to="/signup">Signup</Link>
      </p>
    </div>
  );
}