import React, { useEffect, useState } from 'react';
import { getPayments } from '@/services/api';

export default function AdminPayments() {
  const [payments, setPayments] = useState([]);
  useEffect(() => {
    getPayments().then(setPayments);
  }, []);
  return (
    <div className="p-4">
      <h2 className="text-2xl font-bold mb-4">Payment Records</h2>
      <table className="table-auto w-full"><thead><tr><th>User</th><th>Amount</th><th>Status</th></tr></thead>
        <tbody>
          {payments.map((p, i) => (
            <tr key={i}><td>{p.user}</td><td>{p.amount}</td><td>{p.status}</td></tr>
          ))}
        </tbody>
      </table>
    </div>
  );
}
