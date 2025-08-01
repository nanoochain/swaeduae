import React from "react";
const UAE_PASS_URL = "https://swaeduae.ae/auth/uaepass/login";

const Login = () => {
  const handleUAEPass = () => {
    window.location.href = UAE_PASS_URL;
  };
  return (
    <div className="flex flex-col items-center justify-center min-h-screen">
      <h2 className="text-2xl font-bold mb-4">Sign In to Sawaed UAE</h2>
      {/* ... Email/password login form ... */}
      <button
        onClick={handleUAEPass}
        className="mt-6 bg-blue-700 hover:bg-blue-900 text-white font-semibold py-2 px-6 rounded-lg"
        aria-label="Login with UAE PASS"
      >
        <img src="/uaepass-logo.svg" alt="" className="inline-block mr-2 h-6 align-middle" aria-hidden="true"/>
        Login with UAE PASS
      </button>
    </div>
  );
};
export default Login;
