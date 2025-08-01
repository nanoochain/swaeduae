import React from 'react';

// A simple marketing landing page to introduce volunteers to the platform.
// This replaces the previous placeholder and provides clear calls to action
// for signing up or logging in.  Tailwind CSS classes are used for layout
// and styling.
const Landing = () => (
  <div className="min-h-screen flex flex-col items-center justify-center p-8 bg-gray-50 dark:bg-gray-900">
    <h1 className="text-4xl sm:text-5xl font-bold mb-4 text-gray-900 dark:text-gray-100">
      Sawaed UAE Volunteer Platform
    </h1>
    <p className="mb-6 text-gray-700 dark:text-gray-300 max-w-2xl text-center">
      Join the community of volunteers making a difference across the UAE. Register for
      events, track your contributions, and receive verified certificates for your
      service.
    </p>
    <div className="flex space-x-4">
      <a
        href="/signup"
        className="px-6 py-3 bg-blue-600 text-white rounded shadow hover:bg-blue-700 transition-colors"
      >
        Get Started
      </a>
      <a
        href="/login"
        className="px-6 py-3 bg-gray-200 text-gray-700 rounded shadow hover:bg-gray-300 dark:bg-gray-700 dark:text-gray-200 dark:hover:bg-gray-600 transition-colors"
      >
        Login
      </a>
    </div>
  </div>
);

export default Landing;
