import React, { useState, useEffect } from "react";
import axios from "axios";

export default function ProfileEdit() {
  const [form, setForm] = useState({ username: "", email: "", language: "en", picture: null });
  const [msg, setMsg] = useState("");
  useEffect(() => {
    axios.get("/api/profile").then(res => setForm(res.data));
  }, []);
  function handleChange(e) {
    const { name, value, files } = e.target;
    if (name === "picture") setForm(f => ({ ...f, picture: files[0] }));
    else setForm(f => ({ ...f, [name]: value }));
  }
  function handleSubmit(e) {
    e.preventDefault();
    const data = new FormData();
    for (const k in form) if (form[k]) data.append(k, form[k]);
    axios.post("/api/profile", data).then(() => setMsg("Profile updated!"));
  }
  return (
    <div className="max-w-lg mx-auto p-8">
      <h1 className="text-2xl font-bold mb-6">Edit Profile</h1>
      {msg && <div className="bg-green-100 p-3 mb-3 rounded">{msg}</div>}
      <form onSubmit={handleSubmit} className="space-y-4">
        <input className="border w-full rounded p-2" name="username" value={form.username} onChange={handleChange} placeholder="Username" />
        <input className="border w-full rounded p-2" name="email" value={form.email} onChange={handleChange} placeholder="Email" />
        <select className="border w-full rounded p-2" name="language" value={form.language} onChange={handleChange}>
          <option value="en">English</option>
          <option value="ar">العربية</option>
        </select>
        <input type="file" className="border w-full rounded p-2" name="picture" accept="image/*" onChange={handleChange} />
        <button className="bg-blue-600 text-white px-6 py-2 rounded">Save</button>
      </form>
    </div>
  );
}
