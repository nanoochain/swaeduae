import React, { useState } from 'react';
import { createPayment } from '../../services/api';

export default function PaymentForm() {
  const [amount, setAmount] = useState('');
  const handleSubmit = async (e) => {
    e.preventDefault();
    const res = await createPayment({ amount });
    window.location.href = res.payment_url;
  };
  return (
    <form onSubmit={handleSubmit} className="p-4">
      <h2 className="text-xl font-bold mb-2">Make a Payment</h2>
      <input value={amount} onChange={e => setAmount(e.target.value)} placeholder="Amount AED" />
      <button className="btn btn-success ml-2">Pay</button>
    </form>
  );
}
