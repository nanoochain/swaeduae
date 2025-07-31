import React, { useState } from 'react';
import { verifyOTP } from '@/services/api';

export default function VerifyOTP() {
  const [phone, setPhone] = useState('');
  const [code, setCode] = useState('');
  const handleSubmit = async (e) => {
    e.preventDefault();
    const res = await verifyOTP(phone, code);
    alert(res.message);
  };
  return (
    <form onSubmit={handleSubmit} className="p-4">
      <h2 className="text-xl font-bold mb-2">Verify OTP</h2>
      <input placeholder="Phone" value={phone} onChange={e => setPhone(e.target.value)} />
      <input placeholder="Code" value={code} onChange={e => setCode(e.target.value)} />
      <button className="btn btn-primary">Verify</button>
    </form>
  );
}
