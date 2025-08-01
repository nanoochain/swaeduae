import React from 'react';
export default function VolunteerProfileExtended() {
  return (
    <div className="p-4">
      <h1 className="text-xl font-bold">Extended Volunteer Profile</h1>
      <form className="grid gap-4 mt-4">
        <input placeholder="Emirates ID" className="border p-2" />
        <input placeholder="Driving License No." className="border p-2" />
        <select className="border p-2">
          <option>Gender</option>
          <option>Male</option>
          <option>Female</option>
        </select>
        <input placeholder="Age" className="border p-2" type="number" />
        <input placeholder="Spoken Languages" className="border p-2" />
        <button className="bg-blue-600 text-white px-4 py-2 rounded">Save</button>
      </form>
    </div>
  );
}
