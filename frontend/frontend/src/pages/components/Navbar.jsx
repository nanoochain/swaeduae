import { Link } from 'react-router-dom';
import { useContext } from 'react';
import { AuthContext } from '../context/AuthContext';

const Navbar = () => {
  const { user, logout } = useContext(AuthContext);

  return (
    <nav className="bg-white shadow mb-6">
      <div className="max-w-6xl mx-auto px-4 py-3 flex justify-between items-center">
        <Link to="/" className="text-xl font-bold">Sawaed UAE</Link>
        <div className="space-x-4">
          {user && (
            <>
              <Link to="/dashboard" className="text-gray-700 hover:text-blue-600">Dashboard</Link>
              <Link to="/events" className="text-gray-700 hover:text-blue-600">Events</Link>
              <Link to="/profile" className="text-gray-700 hover:text-blue-600">Profile</Link>
              <button onClick={logout} className="text-red-600 hover:underline">Logout</button>
            </>
          )}
          {!user && (
            <>
              <Link to="/login" className="text-blue-600">Login</Link>
              <Link to="/signup" className="text-blue-600">Signup</Link>
            </>
          )}
        </div>
      </div>
    </nav>
  );
};

export default Navbar;
