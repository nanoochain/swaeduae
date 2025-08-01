import React, { useState, useEffect, useRef } from 'react';
import QRCode from '../lib/qrcode.js';

const API_URL = 'http://localhost:5000';

const Wallet = () => {
  const [wallet, setWallet] = useState(null);
  const [recipient, setRecipient] = useState('');
  const [amount, setAmount] = useState('');
  const [history, setHistory] = useState([]);
  const qrRef = useRef(null);

  // Load or create a wallet on mount
  useEffect(() => {
    const stored = localStorage.getItem('nanoo_wallet');
    if (stored) {
      const parsed = JSON.parse(stored);
      setWallet(parsed);
      fetchHistory(parsed.address);
    } else {
      // request a new wallet from the backend
      fetch(`${API_URL}/wallet/new`)
        .then((res) => res.json())
        .then((data) => {
          setWallet(data);
          localStorage.setItem('nanoo_wallet', JSON.stringify(data));
          fetchHistory(data.address);
        })
        .catch((err) => console.error('Failed to create wallet', err));
    }
  }, []);

  // Render QR code whenever the address changes
  useEffect(() => {
    if (wallet && qrRef.current) {
      qrRef.current.innerHTML = '';
      const qr = new QRCode(qrRef.current, {
        text: wallet.address,
        width: 128,
        height: 128,
        colorDark: '#111827',
        colorLight: '#F9FAFB',
        correctLevel: QRCode.CorrectLevel.H,
      });
    }
  }, [wallet]);

  const fetchHistory = (addr) => {
    fetch(`${API_URL}/transactions/history/${addr}`)
      .then((res) => res.json())
      .then((data) => setHistory(data))
      .catch((err) => console.error('Failed to fetch history', err));
  };

  const handleSend = (e) => {
    e.preventDefault();
    if (!wallet) return;
    const body = {
      recipient,
      amount: parseFloat(amount),
      private_key: wallet.private_key,
    };
    fetch(`${API_URL}/transaction/send`, {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(body),
    })
      .then((res) => res.json())
      .then((data) => {
        alert('Transaction submitted');
        setRecipient('');
        setAmount('');
        // Refresh history to include the new pending transaction
        fetchHistory(wallet.address);
      })
      .catch((err) => console.error('Failed to send transaction', err));
  };

  return (
    <div>
      <h2>Your Wallet</h2>
      {wallet ? (
        <div>
          <p><strong>Address:</strong> {wallet.address}</p>
          <div ref={qrRef} style={{ marginBottom: '1rem' }}></div>
          <form onSubmit={handleSend} style={{ marginBottom: '2rem' }}>
            <h3>Send NanooCoin</h3>
            <div>
              <label>Recipient Address</label>
              <input
                type="text"
                value={recipient}
                onChange={(e) => setRecipient(e.target.value)}
                style={{ width: '100%', padding: '0.5rem', marginBottom: '0.5rem' }}
                required
              />
            </div>
            <div>
              <label>Amount</label>
              <input
                type="number"
                min="0"
                step="any"
                value={amount}
                onChange={(e) => setAmount(e.target.value)}
                style={{ width: '100%', padding: '0.5rem', marginBottom: '0.5rem' }}
                required
              />
            </div>
            <button type="submit" style={{ padding: '0.5rem 1rem' }}>Send</button>
          </form>
          <h3>Transaction History</h3>
          <button onClick={() => fetchHistory(wallet.address)} style={{ marginBottom: '1rem' }}>
            Refresh
          </button>
          {history.length === 0 ? (
            <p>No transactions yet.</p>
          ) : (
            <table style={{ width: '100%', borderCollapse: 'collapse' }}>
              <thead>
                <tr>
                  <th style={{ textAlign: 'left', borderBottom: '1px solid #ddd' }}>Block</th>
                  <th style={{ textAlign: 'left', borderBottom: '1px solid #ddd' }}>Sender</th>
                  <th style={{ textAlign: 'left', borderBottom: '1px solid #ddd' }}>Recipient</th>
                  <th style={{ textAlign: 'left', borderBottom: '1px solid #ddd' }}>Amount</th>
                  <th style={{ textAlign: 'left', borderBottom: '1px solid #ddd' }}>Status</th>
                </tr>
              </thead>
              <tbody>
                {history.map((tx, idx) => (
                  <tr key={idx} style={{ borderBottom: '1px solid #eee' }}>
                    <td>{tx.block_index === null ? 'Pending' : tx.block_index}</td>
                    <td>{tx.sender}</td>
                    <td>{tx.recipient}</td>
                    <td>{tx.amount}</td>
                    <td>{tx.block_index === null ? 'Pending' : 'Confirmed'}</td>
                  </tr>
                ))}
              </tbody>
            </table>
          )}
        </div>
      ) : (
        <p>Loading wallet...</p>
      )}
    </div>
  );
};

export default Wallet;