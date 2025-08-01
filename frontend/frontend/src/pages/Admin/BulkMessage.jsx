import React, { useState } from "react";
import { sendBulkMessage } from "@/services/api";

export default function BulkMessage() {
  const [subject, setSubject] = useState("");
  const [message, setMessage] = useState("");
  const [status, setStatus] = useState("");

  const handleSend = async (e) => {
    e.preventDefault();
    setStatus("Sending...");
    await sendBulkMessage({ subject, message });
    setStatus("Sent!");
  };

  return (
    <form onSubmit={handleSend} className="bg-white shadow rounded p-4 mt-4">
      <h2 className="font-bold mb-2">Bulk Message Volunteers</h2>
      <input className="input mb-2" placeholder="Subject" value={subject} onChange={e => setSubject(e.target.value)} />
      <textarea className="input mb-2" placeholder="Message" value={message} onChange={e => setMessage(e.target.value)} />
      <button className="btn btn-primary">Send to All Registered Volunteers</button>
      {status && <div className="mt-2">{status}</div>}
    </form>
  );
}
