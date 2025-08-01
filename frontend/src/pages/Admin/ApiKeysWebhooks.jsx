import React, { useEffect, useState } from "react";
import axios from "axios";
export default function ApiKeysWebhooks() {
  const [keys, setKeys] = useState([]);
  const [webhooks, setWebhooks] = useState([]);
  useEffect(() => {
    axios.get("/api/admin/api-keys").then(r => setKeys(r.data));
    axios.get("/api/admin/webhooks").then(r => setWebhooks(r.data));
  }, []);
  function createKey() {
    axios.post("/api/admin/api-keys").then(() => window.location.reload());
  }
  function addWebhook() {
    const url = prompt("Enter webhook URL");
    if (!url) return;
    axios.post("/api/admin/webhooks", { url }).then(() => window.location.reload());
  }
  return (
    <div className="p-8">
      <h1 className="font-bold text-2xl mb-4">API Keys & Webhooks</h1>
      <button className="bg-blue-700 text-white px-4 py-1 rounded mr-4" onClick={createKey}>New API Key</button>
      <button className="bg-green-700 text-white px-4 py-1 rounded" onClick={addWebhook}>Add Webhook</button>
      <div className="mt-6">
        <h2 className="font-bold mb-2">Keys</h2>
        <ul>{keys.map((k, i) => <li key={i}>{k.key}</li>)}</ul>
        <h2 className="font-bold mt-4 mb-2">Webhooks</h2>
        <ul>{webhooks.map((w, i) => <li key={i}>{w.url}</li>)}</ul>
      </div>
    </div>
  );
}
