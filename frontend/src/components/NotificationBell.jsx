import React, { useEffect, useState } from "react";
import { FaBell } from "react-icons/fa";
import axios from "axios";
export default function NotificationBell() {
  const [count, setCount] = useState(0);
  const [open, setOpen] = useState(false);
  const [notes, setNotes] = useState([]);
  useEffect(() => {
    axios.get("/api/notifications").then(res => {
      setCount(res.data.length); setNotes(res.data);
    });
  }, []);
  return (
    <div className="relative">
      <button className="relative" onClick={() => setOpen(o => !o)}>
        <FaBell className="text-xl" />
        {count > 0 && <span className="absolute -top-1 -right-1 bg-red-600 text-white rounded-full px-2 py-0.5 text-xs">{count}</span>}
      </button>
      {open && (
        <div className="absolute right-0 bg-white border shadow-lg rounded-xl mt-2 p-4 z-20 w-64">
          <h4 className="font-bold mb-2">Notifications</h4>
          {notes.length === 0 ? <p>No notifications.</p> : notes.map((n, i) => (
            <div key={i} className="mb-2 p-2 rounded bg-blue-50">{n.text}</div>
          ))}
        </div>
      )}
    </div>
  );
}
