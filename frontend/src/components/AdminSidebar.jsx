import React from "react";
import { Link, useLocation } from "react-router-dom";
const menu = [
  { label: "Dashboard", icon: "🏠", path: "/admin/dashboard" },
  { label: "Users", icon: "👤", path: "/admin/users" },
  { label: "Events", icon: "🎉", path: "/admin/events" },
  { label: "KYC Approvals", icon: "✅", path: "/admin/kyc" },
  { label: "Certificates", icon: "📄", path: "/admin/certificates" },
  { label: "Logs", icon: "📝", path: "/admin/logs" },
  { label: "Settings", icon: "⚙️", path: "/admin/settings" },
];
export default function AdminSidebar() {
  const loc = useLocation();
  return (
    <aside className="min-h-screen w-56 bg-white dark:bg-neutral-900 border-r px-3 py-6 flex flex-col gap-2 shadow-lg">
      <div className="mb-8 text-xl font-bold text-primary-700 dark:text-primary-200">Sawaed Admin</div>
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
