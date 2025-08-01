import React, { useState } from "react";
import axios from "axios";

export default function Feedback() {
  const [form, setForm] = useState({ rating: 5, comments: "" });
  const [success, setSuccess] = useState(false);
  const handleChange = e => setForm({ ...form, [e.target.name]: e.target.value });
  const handleSubmit = e => {
    e.preventDefault();
    axios.post("/api/feedback", form).then(() => setSuccess(true));
  };
  return (
    <div className="max-w-lg mx-auto py-12">
      <h1 className="text-2xl font-bold mb-6">Share Your Event Feedback</h1>
      {success ? (
        <div className="bg-green-100 text-green-700 p-4 rounded">Thank you for your feedback!</div>
      ) : (
        <form onSubmit={handleSubmit} className="space-y-4 bg-white p-6 rounded shadow">
          <label className="block font-semibold">Rating</label>
          <select name="rating" className="w-full rounded border px-2 py-1" value={form.rating} onChange={handleChange}>
            {[5,4,3,2,1].map(v => <option key={v} value={v}>{v}</option>)}
          </select>
          <label className="block font-semibold">Comments</label>
          <textarea name="comments" className="w-full rounded border px-2 py-1" rows={5} value={form.comments} onChange={handleChange} />
          <button className="bg-yellow-500 text-white px-6 py-2 rounded" type="submit">Submit Feedback</button>
        </form>
      )}
    </div>
  );
}
