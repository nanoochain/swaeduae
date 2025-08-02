import React, { useState } from 'react';
import { verifyOTP } from '../services/api.js';

/*
 * Allows users to verify a one‑time password sent to their phone. The
 * backend endpoint `/verify-otp` accepts a phone number and code and
 * returns a JSON response indicating success or failure【530913800322578†L24-L35】.
 */
export default function VerifyOTP() {
  const [phone, setPhone] = useState('');
  const [code, setCode] = useState('');
  const [message, setMessage] = useState(null);
  const handleSubmit = async (e) => {
    e.preventDefault();
    if (!phone || !code) return;
    try {
      const res = await verifyOTP(phone, code);
      setMessage(res.message || JSON.stringify(res));
    } catch (err) {
      setMessage('Verification failed');
    }
  };
  return (
    <div>
      <h1>Verify OTP</h1>
      <form onSubmit={handleSubmit}>
        <input
          type="tel"
          placeholder="Phone Number"
          value={phone}
          onChange={(e) => setPhone(e.target.value)}
        />
        <input
          type="text"
          placeholder="OTP Code"
          value={code}
          onChange={(e) => setCode(e.target.value)}
        />
        <button type="submit">Verify</button>
      </form>
      {message && <p>{message}</p>}
    </div>
  );
}