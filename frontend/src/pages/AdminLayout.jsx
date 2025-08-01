import React from "react";
import AdminSidebar from "../components/AdminSidebar";
export default function AdminLayout({ children }) {
  return (
    <div className="flex">
      <AdminSidebar />
      <div className="flex-1 min-h-screen bg-neutral-50 dark:bg-neutral-900">
        {children}
      </div>
    </div>
  );
}
