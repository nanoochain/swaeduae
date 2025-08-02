import React, { useEffect, useState } from 'react';
import { listCertificates, createCertificate } from '../../services/api.js';

/*
 * Administrators can view all certificates and issue new ones to volunteers
 * from this page. The `/admin/certificates` endpoint provides a list of
 * certificate objects【15469675107366†L59-L71】 and also accepts POST
 * requests to create a new certificate for a user and event pair
 *【15469675107366†L73-L85】. After creation the list is refreshed to include
 * the newly issued certificate.
 */
export default function AdminCertificates() {
  const [certs, setCerts] = useState([]);
  const [form, setForm] = useState({ user_id: '', event_id: '' });
  useEffect(() => {
    listCertificates()
      .then((res) => {
        const list = res.certificates || res;
        setCerts(Array.isArray(list) ? list : []);
      })
      .catch((err) => console.error(err));
  }, []);
  const handleSubmit = async (e) => {
    e.preventDefault();
    if (!form.user_id || !form.event_id) return;
    try {
      await createCertificate(form.user_id, form.event_id);
      const updated = await listCertificates();
      const list = updated.certificates || updated;
      setCerts(Array.isArray(list) ? list : []);
      setForm({ user_id: '', event_id: '' });
    } catch (err) {
      console.error(err);
    }
  };
  return (
    <div>
      <h1>Certificates</h1>
      <form onSubmit={handleSubmit}>
        <input
          type="number"
          placeholder="User ID"
          value={form.user_id}
          onChange={(e) => setForm({ ...form, user_id: e.target.value })}
        />
        <input
          type="number"
          placeholder="Event ID"
          value={form.event_id}
          onChange={(e) => setForm({ ...form, event_id: e.target.value })}
        />
        <button type="submit">Create Certificate</button>
      </form>
      {certs.length === 0 ? (
        <p>No certificates found.</p>
      ) : (
        <table>
          <thead>
            <tr>
              <th>ID</th>
              <th>User ID</th>
              <th>Event ID</th>
              <th>Issued At</th>
            </tr>
          </thead>
          <tbody>
            {certs.map((c) => (
              <tr key={c.id}>
                <td>{c.id}</td>
                <td>{c.user_id}</td>
                <td>{c.event_id}</td>
                <td>{c.issued_at}</td>
              </tr>
            ))}
          </tbody>
        </table>
      )}
    </div>
  );
}