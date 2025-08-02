import React, { useState } from 'react';
import { createPayment } from '../services/api.js';

/*
 * Payment form for volunteers to make donations or pay event fees. It
 * calls the `/payment` endpoint which returns a payment_url
 * redirecting the user to a third‑party processor (Stripe, for
 * example). This page displays the link after the payment session is
 * created.
 */
export default function PaymentForm() {
  const [amount, setAmount] = useState('');
  const [paymentUrl, setPaymentUrl] = useState(null);
  const handleSubmit = async (e) => {
    e.preventDefault();
    if (!amount) return;
    try {
      const res = await createPayment({ amount: parseFloat(amount) });
      setPaymentUrl(res.payment_url || res.url);
    } catch (err) {
      console.error(err);
    }
  };
  return (
    <div>
      <h1>Payment</h1>
      <form onSubmit={handleSubmit}>
        <input
          type="number"
          placeholder="Amount (AED)"
          value={amount}
          onChange={(e) => setAmount(e.target.value)}
        />
        <button type="submit">Pay</button>
      </form>
      {paymentUrl && (
        <p>
          Payment session created –{' '}
          <a href={paymentUrl} target="_blank" rel="noopener noreferrer">
            Complete payment
          </a>
        </p>
      )}
    </div>
  );
}