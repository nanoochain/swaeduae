import React, { useState } from 'react';
import { verifyOTP } from '../../services/api';

export default function VerifyOTP() {
  const [otp, setOtp] = useState('');

  const handleSubmit = async (e) => {
    e.preventDefault();
    const result = await verifyOTP({ otp });
    if (result.success) {
      alert('OTP Verified!');
      window.location.href = '/dashboard';
    } else {
      alert('Invalid OTP');
    }
  };

  return (
    <form onSubmit={handleSubmit} className="p-4">
      <h2 className="text-xl font-bold mb-2">Verify OTP</h2>
      <input
        type="text"
        value={otp}
        onChange={(e) => setOtp(e.target.value)}
        placeholder="Enter OTP"
        className="border p-2 rounded mr-2"
      />
      <button type="submit" className="btn btn-primary">Verify</button>
    </form>
  );
}
