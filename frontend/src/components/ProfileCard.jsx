import React from "react";
export default function ProfileCard({ user }) {
  return (
    <div className="max-w-sm mx-auto bg-white rounded-xl shadow-xl overflow-hidden p-6 text-center">
      <img src={user.photo_url || "/avatar.svg"} className="w-24 h-24 mx-auto rounded-full border-4 border-blue-200 mb-4" alt="Avatar" />
      <h2 className="font-bold text-xl">{user.username}</h2>
      <div className="text-gray-600 mb-2">{user.badge && <span>{user.badge}</span>}</div>
      <div className="font-semibold mb-2">{user.hours} volunteer hours</div>
      <a className="inline-block bg-green-700 text-white px-3 py-1 rounded mr-2" href={user.cert_url}>Download Certificate</a>
      <a className="inline-block bg-blue-700 text-white px-3 py-1 rounded" href={`https://www.linkedin.com/sharing/share-offsite/?url=${encodeURIComponent(user.cert_url)}`} target="_blank" rel="noopener">Share on LinkedIn</a>
    </div>
  );
}
