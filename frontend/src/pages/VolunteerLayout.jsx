import React from "react";
import VolunteerSidebar from "../components/VolunteerSidebar";
export default function VolunteerLayout({ children }) {
  return (
    <div className="flex">
      <VolunteerSidebar />
      <div className="flex-1 min-h-screen bg-neutral-50 dark:bg-neutral-900">
        {children}
      </div>
    </div>
  );
}
