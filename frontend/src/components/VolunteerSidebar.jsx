import React from "react";
import { Link, useLocation } from "react-router-dom";
const menu = [
  { label: "Dashboard", icon: "🏠", path: "/dashboard" },
  { label: "Events", icon: "🎉", path: "/events" },
  { label: "Certificates", icon: "📄", path: "/certificates" },
  { label: "Profile", icon: "👤", path: "/profile" },
];
export default function VolunteerSidebar() {
  const loc = useLocation();
  return (
    <aside className="min-h-screen w-44 bg-primary-50 dark:bg-neutral-900 border-r px-2 py-6 flex flex-col gap-2 shadow">
      <div className="mb-7 text-lg font-bold text-primary-700 dark:text-primary-200">Volunteer</div>
      {menu.map((item) => (
        <Link key={item.path} to={item.path}
          className={`flex items-center gap-3 p-3 rounded-xl transition
            ${loc.pathname.startsWith(item.path)
              ? "bg-primary-600 text-white"
              : "hover:bg-primary-100 dark:hover:bg-neutral-700 text-neutral-700 dark:text-neutral-100"}`}>
          <span>{item.icon}</span>
          <span>{item.label}</span>
        </Link>
      ))}
    </aside>
  );
}
