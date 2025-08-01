import React from "react";
import axios from "axios";

export default function DBBackupRestore() {
  function handleBackup() {
    window.open("/api/db/backup", "_blank");
  }
  async function handleRestore(e) {
    const file = e.target.files[0];
    if (!file) return;
    const data = new FormData();
    data.append("file", file);
    await axios.post("/api/db/restore", data);
    alert("DB restored! Please reload the backend server.");
  }
  return (
    <div className="p-8">
      <h1 className="text-2xl font-bold mb-6">Database Backup / Restore</h1>
      <button className="bg-blue-600 text-white px-4 py-2 rounded mr-4" onClick={handleBackup}>Download Backup</button>
      <input type="file" className="mt-2" accept=".sqlite3,.db" onChange={handleRestore} />
    </div>
  );
}
