import React, { useState } from 'react';

function Signup() {
  const [email, setEmail] = useState('');
  const [password, setPassword] = useState('');

  const handleSignup = async (e) => {
    e.preventDefault();
    const res = await fetch('/signup', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ email, password }),
    });
    const data = await res.json();
    alert(data.message || 'Signup successful!');
  };

  return (
    <div className="flex justify-center items-center h-screen bg-gray-100">
      <form onSubmit={handleSignup} className="bg-white p-6 rounded shadow-md w-96">
        <h2 className="text-2xl font-bold mb-4">Signup</h2>
        <input type="email" value={email} onChange={(e) => setEmail(e.target.value)} placeholder="Email" className="w-full p-2 mb-2 border rounded" />
        <input type="password" value={password} onChange={(e) => setPassword(e.target.value)} placeholder="Password" className="w-full p-2 mb-4 border rounded" />
        <button type="submit" className="bg-green-600 text-white p-2 w-full rounded hover:bg-green-700">Sign Up</button>
      </form>
    </div>
  );
}

export default Signup;