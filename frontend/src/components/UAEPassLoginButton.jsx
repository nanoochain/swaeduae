import React from 'react';

export default function UAEPassLoginButton() {
  const handleLogin = () => {
    window.location.href = '/uaepass/login';
  };

  return (
    <button onClick={handleLogin} style={{ backgroundColor: '#007a33', color: 'white', padding: '10px 20px', borderRadius: '5px', border: 'none' }}>
      Login with UAE PASS
    </button>
  );
}
