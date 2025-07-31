import React from 'react';
import { Link } from 'react-router-dom';

export default function Home() {
  return (
    <div className="min-h-screen bg-white text-gray-900 dark:bg-gray-900 dark:text-white">
      <div className="max-w-7xl mx-auto px-6 py-16 text-center">
        <h1 className="text-4xl md:text-6xl font-bold mb-4">
          Sawaed Emirates Volunteer Society
        </h1>
        <p className="text-lg md:text-xl mb-8">
          Unite. Serve. Empower. Join us in making a difference across the UAE.
        </p>
        <div className="flex justify-center gap-4">
          <Link to="/signup">
            <button className="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-lg transition">
              Get Started
            </button>
          </Link>
          <Link to="/events">
            <button className="bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-3 px-6 rounded-lg transition dark:bg-gray-700 dark:text-white dark:hover:bg-gray-600">
              Explore Events
            </button>
          </Link>
        </div>
      </div>
    </div>
  );
}
