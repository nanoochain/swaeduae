import React, { useEffect, useState } from "react";
import axios from "axios";

export default function AdminLogs() {
  const [logs, setLogs] = useState("");
  useEffect(() => {
    axios.get("/api/logs")
      .then(res => setLogs(typeof res.data === "string" ? res.data : JSON.stringify(res.data, null, 2)))
      .catch(() => setLogs("No logs found or error loading log file."));
  }, []);
  return (
    <div className="p-8">
      <h1 className="text-2xl font-bold mb-6">System Logs</h1>
      <pre className="bg-gray-900 text-green-300 p-4 rounded overflow-x-auto h-96">{logs}</pre>
    </div>
  );
}
