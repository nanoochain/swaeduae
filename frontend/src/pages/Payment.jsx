import React, { useState } from "react";
import axios from "axios";

export default function Payment() {
  const [amount, setAmount] = useState("");
  const [secret, setSecret] = useState("");
  const [error, setError] = useState("");
  const handlePay = async e => {
    e.preventDefault();
    setError(""); setSecret("");
    try {
      const res = await axios.post("/api/pay", { amount });
      setSecret(res.data.clientSecret);
    } catch (e) {
      setError(e.response?.data?.error || "Payment error");
    }
  };
  return (
    <div className="max-w-md mx-auto my-12 p-8 bg-white rounded-xl shadow">
      <h1 className="text-2xl font-bold mb-6">Support Sawaed UAE</h1>
      <form onSubmit={handlePay} className="space-y-4">
        <input
          type="number"
          step="0.01"
          value={amount}
          onChange={e => setAmount(e.target.value)}
          className="w-full border rounded px-3 py-2"
          placeholder="Amount in AED"
          required
        />
        <button className="bg-green-600 text-white rounded px-5 py-2">Pay</button>
      </form>
      {secret && <div className="mt-6 text-green-700">Payment initialized! Complete payment using Stripe client.</div>}
      {error && <div className="mt-6 text-red-700">{error}</div>}
    </div>
  );
}
