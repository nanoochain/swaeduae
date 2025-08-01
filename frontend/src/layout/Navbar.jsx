import React from 'react';
import { Link } from 'react-router-dom';

export default function Navbar() {
  return (
    <nav className="bg-white shadow-md px-4 py-3 flex justify-between items-center">
      <h1 className="text-xl font-bold text-blue-800">Sawaed UAE</h1>
      <div className="space-x-4">
        <Link to="/dashboard" className="text-gray-700 hover:text-blue-600">Dashboard</Link>
        <Link to="/events" className="text-gray-700 hover:text-blue-600">Events</Link>
        <Link to="/certificates" className="text-gray-700 hover:text-blue-600">Certificates</Link>
      </div>
    </nav>
  );
}
