import React, { useEffect, useState } from "react";
import { getProfile } from "@/services/api";
export default function Profile() {
  const [profile, setProfile] = useState({});
  useEffect(() => { getProfile().then(setProfile); }, []);
  return (
    <div className="p-6 max-w-xl">
      <h1 className="text-2xl font-bold mb-4">My Profile</h1>
      <div className="p-5 bg-white dark:bg-neutral-800 rounded-xl shadow space-y-2">
        <div><b>Name:</b> {profile.username}</div>
        <div><b>Email:</b> {profile.email}</div>
        <div><b>Role:</b> {profile.role}</div>
        <div><b>Org:</b> {profile.org_name}</div>
        {/* Add edit options */}
      </div>
    </div>
  );
}
