import { Link } from 'react-router-dom';
import { useContext } from 'react';
import { AuthContext } from '../context/AuthContext';

const Sidebar = () => {
  const { user, logout } = useContext(AuthContext);

  return (
    <div className="w-64 bg-white shadow h-screen p-4 space-y-4">
      <h2 className="text-2xl font-bold">Sawaed UAE</h2>
      <nav className="flex flex-col space-y-2">
        <Link to="/dashboard" className="text-blue-600 hover:underline">Dashboard</Link>
        <Link to="/events" className="text-blue-600 hover:underline">Events</Link>
        <Link to="/profile" className="text-blue-600 hover:underline">Profile</Link>
        {user?.role === 'admin' && (
          <Link to="/admin" className="text-red-600 font-semibold hover:underline">Admin Panel</Link>
        )}
        <button onClick={logout} className="text-sm text-gray-600 mt-4">Logout</button>
      </nav>
    </div>
  );
};

export default Sidebar;
