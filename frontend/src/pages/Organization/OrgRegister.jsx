import React from 'react';
export default function OrgRegister() {
  return (
    <div className="p-4">
      <h1 className="text-xl font-bold">Organization Registration</h1>
      <form className="grid gap-4 mt-4">
        <input placeholder="Entity Name" className="border p-2" />
        <input placeholder="Email" className="border p-2" />
        <input placeholder="Phone" className="border p-2" />
        <input placeholder="Trade License No." className="border p-2" />
        <textarea placeholder="Description" className="border p-2" />
        <button className="bg-green-600 text-white px-4 py-2 rounded">Submit</button>
      </form>
    </div>
  );
}
