import React from "react";
import AdminAnalytics from "./AdminAnalytics";
import DeliveryLogs from "./DeliveryLogs";
import BulkMessage from "./BulkMessage";

export default function AdminDashboard() {
  return (
    <div className="p-4">
      <h1 className="text-2xl font-bold mb-4">Admin Dashboard</h1>
      <div className="grid md:grid-cols-2 gap-6">
        <AdminAnalytics />
        <DeliveryLogs />
      </div>
      <div className="mt-6">
        <BulkMessage />
      </div>
    </div>
  );
}
