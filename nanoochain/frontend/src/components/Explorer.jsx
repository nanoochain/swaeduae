import React, { useState, useEffect } from 'react';

const API_URL = 'http://localhost:5000';

const Explorer = () => {
  const [chain, setChain] = useState([]);
  const [selectedBlock, setSelectedBlock] = useState(null);
  const [search, setSearch] = useState('');
  const [searchResult, setSearchResult] = useState(null);

  useEffect(() => {
    fetch(`${API_URL}/chain`)
      .then((res) => res.json())
      .then((data) => setChain(data))
      .catch((err) => console.error('Failed to load chain', err));
  }, []);

  const openBlock = (index) => {
    fetch(`${API_URL}/explorer/block/${index}`)
      .then((res) => res.json())
      .then((data) => setSelectedBlock(data))
      .catch((err) => console.error('Failed to load block', err));
  };

  const handleSearch = (e) => {
    e.preventDefault();
    if (!search) return;
    fetch(`${API_URL}/explorer/transaction/${search}`)
      .then((res) => res.json())
      .then((data) => setSearchResult(data))
      .catch((err) => console.error('Transaction search failed', err));
  };

  return (
    <div>
      <h2>Block Explorer</h2>
      <form onSubmit={handleSearch} style={{ marginBottom: '1rem' }}>
        <input
          type="text"
          placeholder="Search by transaction signature"
          value={search}
          onChange={(e) => setSearch(e.target.value)}
          style={{ width: '60%', padding: '0.5rem', marginRight: '0.5rem' }}
        />
        <button type="submit">Search</button>
      </form>
      {searchResult && !searchResult.error && (
        <div style={{ marginBottom: '1rem', padding: '0.5rem', border: '1px solid #ddd' }}>
          <h4>Transaction found in block {searchResult.block_index}</h4>
          <pre style={{ whiteSpace: 'pre-wrap', wordBreak: 'break-word' }}>
{JSON.stringify(searchResult.transaction, null, 2)}
          </pre>
        </div>
      )}
      {searchResult && searchResult.error && (
        <p style={{ color: 'red' }}>{searchResult.error}</p>
      )}
      <h3>Blocks</h3>
      {chain.length === 0 ? (
        <p>No blocks yet.</p>
      ) : (
        <table style={{ width: '100%', borderCollapse: 'collapse' }}>
          <thead>
            <tr>
              <th style={{ textAlign: 'left', borderBottom: '1px solid #ddd' }}>Index</th>
              <th style={{ textAlign: 'left', borderBottom: '1px solid #ddd' }}>Hash</th>
              <th style={{ textAlign: 'left', borderBottom: '1px solid #ddd' }}>Prev Hash</th>
              <th style={{ textAlign: 'left', borderBottom: '1px solid #ddd' }}>Transactions</th>
            </tr>
          </thead>
          <tbody>
            {chain.map((blk) => (
              <tr key={blk.index} style={{ borderBottom: '1px solid #eee', cursor: 'pointer' }} onClick={() => openBlock(blk.index)}>
                <td>{blk.index}</td>
                <td style={{ maxWidth: '200px', overflow: 'hidden', textOverflow: 'ellipsis' }}>{blk.hash}</td>
                <td style={{ maxWidth: '200px', overflow: 'hidden', textOverflow: 'ellipsis' }}>{blk.previous_hash}</td>
                <td>{blk.transactions.length}</td>
              </tr>
            ))}
          </tbody>
        </table>
      )}
      {selectedBlock && (
        <div style={{ marginTop: '1rem', padding: '1rem', border: '1px solid #ddd' }}>
          <h4>Block {selectedBlock.index}</h4>
          <p><strong>Hash:</strong> {selectedBlock.hash}</p>
          <p><strong>Previous Hash:</strong> {selectedBlock.previous_hash}</p>
          <p><strong>Nonce:</strong> {selectedBlock.nonce}</p>
          <p><strong>Timestamp:</strong> {selectedBlock.timestamp}</p>
          <h5>Transactions ({selectedBlock.transactions.length})</h5>
          <pre style={{ whiteSpace: 'pre-wrap', wordBreak: 'break-word' }}>
{JSON.stringify(selectedBlock.transactions, null, 2)}
          </pre>
        </div>
      )}
    </div>
  );
};

export default Explorer;