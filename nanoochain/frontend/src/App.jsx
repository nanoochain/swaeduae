import React from 'react';
import { NavLink, Routes, Route } from 'react-router-dom';
import Wallet from './components/Wallet.jsx';
import Explorer from './components/Explorer.jsx';
import Stats from './components/Stats.jsx';

const App = () => {
  return (
    <div>
      <nav>
        <div>
          <NavLink to="/" style={{ marginRight: '1rem' }}>
            NanooChain
          </NavLink>
        </div>
        <div>
          <NavLink to="/wallet" style={{ marginRight: '1rem' }}>
            Wallet
          </NavLink>
          <NavLink to="/explorer" style={{ marginRight: '1rem' }}>
            Explorer
          </NavLink>
          <NavLink to="/stats" style={{ marginRight: '1rem' }}>
            Stats
          </NavLink>
        </div>
      </nav>
      <main style={{ padding: '1rem' }}>
        <Routes>
          <Route path="/" element={<Stats />} />
          <Route path="/wallet" element={<Wallet />} />
          <Route path="/explorer" element={<Explorer />} />
          <Route path="/stats" element={<Stats />} />
        </Routes>
      </main>
    </div>
  );
};

export default App;