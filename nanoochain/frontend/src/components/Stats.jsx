import React, { useState, useEffect } from 'react';

const API_URL = 'http://localhost:5000';

const Stats = () => {
  const [stats, setStats] = useState(null);

  const loadStats = () => {
    fetch(`${API_URL}/stats`)
      .then((res) => res.json())
      .then((data) => setStats(data))
      .catch((err) => console.error('Failed to load stats', err));
  };

  useEffect(() => {
    loadStats();
    const interval = setInterval(loadStats, 5000);
    return () => clearInterval(interval);
  }, []);

  return (
    <div>
      <h2>Chain Statistics</h2>
      {stats ? (
        <div>
          <p><strong>Number of blocks:</strong> {stats.num_blocks}</p>
          <p><strong>Latest block hash:</strong> {stats.latest_hash}</p>
          <p><strong>Number of peers:</strong> {stats.num_peers}</p>
          <p><strong>Mempool size:</strong> {stats.mempool_size}</p>
        </div>
      ) : (
        <p>Loading stats...</p>
      )}
    </div>
  );
};

export default Stats;