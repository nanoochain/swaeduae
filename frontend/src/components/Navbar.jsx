import React, { useContext } from 'react';
import { Link } from 'react-router-dom';
import { AuthContext } from '../context/AuthContext';

function Navbar() {
  const { token, logout, role } = useContext(AuthContext);
  return (
    <nav className="p-4 bg-gray-800 text-white flex justify-between">
      <div>
        {token && (
          <>
            <Link to="/dashboard" className="mr-4">Dashboard</Link>
            <Link to="/events" className="mr-4">Events</Link>
            <Link to="/profile" className="mr-4">Profile</Link>
            {role === 'admin' && <Link to="/admin" className="mr-4">Admin</Link>}
          </>
        )}
      </div>
      <div>
        {token
          ? <button onClick={logout} className="text-red-400">Logout</button>
          : <>
              <Link to="/" className="mr-4">Login</Link>
              <Link to="/signup">Signup</Link>
            </>
        }
      </div>
    </nav>
  );
}

export default Navbar;