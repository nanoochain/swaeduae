import React, { useState } from 'react'
import axios from 'axios'

const AdminCertificateSender = () => {
  const [form, setForm] = useState({
    name: '',
    email: '',
    event_title: '',
    event_date: ''
  })
  const [message, setMessage] = useState('')

  const handleChange = e => {
    setForm({ ...form, [e.target.name]: e.target.value })
  }

  const handleSubmit = async e => {
    e.preventDefault()
    try {
      const res = await axios.post('/certificates/send', form)
      setMessage(res.data.message)
    } catch (err) {
      setMessage('Error sending certificate')
    }
  }

  return (
    <div className="max-w-lg mx-auto bg-white shadow p-6 mt-6 rounded">
      <h2 className="text-2xl font-bold mb-4">Send Certificate</h2>
      <form onSubmit={handleSubmit} className="space-y-3">
        {['name', 'email', 'event_title', 'event_date'].map(field => (
          <input
            key={field}
            name={field}
            value={form[field]}
            onChange={handleChange}
            placeholder={field.replace('_', ' ').toUpperCase()}
            className="w-full border p-2 rounded"
            required
          />
        ))}
        <button type="submit" className="bg-green-600 text-white px-4 py-2 rounded">Send</button>
      </form>
      {message && <p className="mt-4 text-blue-600">{message}</p>}
    </div>
  )
}

export default AdminCertificateSender
