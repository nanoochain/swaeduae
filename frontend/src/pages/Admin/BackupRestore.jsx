import React from "react";
const handleBackup = () => {
  window.open("/api/admin/backup", "_blank");
};
const handleRestore = () => {
  alert("Restore feature coming soon. Use backend scripts for now.");
};
const BackupRestore = () => (
  <div className="p-4">
    <h2 className="text-xl font-bold mb-4">Backup & Restore Database</h2>
    <button onClick={handleBackup} className="bg-blue-600 text-white rounded px-4 py-2 mr-4">Download Backup</button>
    <button onClick={handleRestore} className="bg-gray-400 text-white rounded px-4 py-2">Restore (Coming Soon)</button>
  </div>
);
export default BackupRestore;
