import React, { createContext, useContext, useState } from 'react';

const AuthContext = createContext();

export const AuthProvider = ({ children }) => {
  const [token, setToken] = useState(localStorage.getItem('token') || '');
  const [login, setLogin] = useState(false);

  const loginUser = (newToken) => {
    setToken(newToken);
    localStorage.setItem('token', newToken);
    setLogin(true);
  };

  const logoutUser = () => {
    setToken('');
    localStorage.removeItem('token');
    setLogin(false);
  };

  return (
    <AuthContext.Provider value={{ token, login, loginUser, logoutUser }}>
      {children}
    </AuthContext.Provider>
  );
};

export const useAuth = () => useContext(AuthContext);
