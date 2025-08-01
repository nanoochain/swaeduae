import React from "react";
import { Link } from "react-router-dom";
export default function Navbar() {
  return (
    <nav className="flex items-center bg-primary-700 text-white px-6 py-3 shadow">
      <Link to="/" className="font-bold text-xl mr-8">SawaedUAE</Link>
      <Link to="/events" className="mx-2">Events</Link>
      <Link to="/certificates" className="mx-2">Certificates</Link>
      <Link to="/profile" className="mx-2">Profile</Link>
      <Link to="/admin/dashboard" className="mx-2">Admin</Link>
    </nav>
  );
}
