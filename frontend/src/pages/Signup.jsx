import React, { useState } from 'react';
import { useAuth } from '../context/AuthContext.jsx';
import { Navigate, Link } from 'react-router-dom';

/*
 * Registration form. Invokes the AuthContext `signup` method which
 * posts the username, email and password to the `/signup` endpoint.
 * After registering the user is automatically logged in and
 * redirected to their dashboard. Existing users are redirected away.
 */
export default function Signup() {
  const { user, signup } = useAuth();
  const [username, setUsername] = useState('');
  const [email, setEmail] = useState('');
  const [password, setPassword] = useState('');
  const [error, setError] = useState(null);
  const handleSubmit = async (e) => {
    e.preventDefault();
    try {
      await signup(username, email, password);
    } catch (err) {
      setError('Unable to register');
    }
  };
  if (user) return <Navigate to="/dashboard" replace />;
  return (
    <div>
      <h1>Signup</h1>
      <form onSubmit={handleSubmit}>
        <input
          type="text"
          placeholder="Username"
          value={username}
          onChange={(e) => setUsername(e.target.value)}
        />
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
        <button type="submit">Signup</button>
      </form>
      {error && <p style={{ color: 'red' }}>{error}</p>}
      <p>
        Have an account? <Link to="/login">Login</Link>
      </p>
    </div>
  );
}