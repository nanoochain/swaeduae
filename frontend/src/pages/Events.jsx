import React, { useEffect, useState } from 'react'
import Sidebar from '../components/Sidebar'
import axios from 'axios'
import { useAuth } from '../context/AuthContext'

export default function Events() {
  const [events, setEvents] = useState([])
  const { token } = useAuth()

  useEffect(() => {
    axios.get(`${import.meta.env.VITE_API_URL}/events`)
      .then(res => setEvents(res.data))
      .catch(err => console.error(err))
  }, [])

  const handleRegister = (id) => {
    axios.post(`${import.meta.env.VITE_API_URL}/events/register`, { event_id: id }, {
      headers: { Authorization: `Bearer ${token}` }
    }).then(() => alert("Registered!"))
      .catch(() => alert("Already registered or error."))
  }

  return (
    <div className="flex">
      <Sidebar />
      <div className="p-8">
        <h1 className="text-2xl font-bold mb-4">Events</h1>
        {events.map(e => (
          <div key={e.id} className="mb-4 p-4 border rounded shadow">
            <h2 className="text-xl font-semibold">{e.title}</h2>
            <p>{e.description}</p>
            <p><strong>Date:</strong> {e.date}</p>
            <button onClick={() => handleRegister(e.id)} className="mt-2 bg-blue-600 text-white p-2 rounded">Register</button>
          </div>
        ))}
      </div>
    </div>
  )
}
