import React from 'react'
import Sidebar from '../components/Sidebar'
import { useEffect, useState } from 'react'
import axios from 'axios'

export default function Dashboard() {
  const [stats, setStats] = useState({})
  useEffect(() => {
    axios.get(`${import.meta.env.VITE_API_URL}/admin/stats`)
      .then(res => setStats(res.data))
      .catch(err => console.error(err))
  }, [])
  return (
    <div className="flex">
      <Sidebar />
      <div className="p-8">
        <h1 className="text-2xl font-bold mb-4">Dashboard</h1>
        <p><strong>Total Users:</strong> {stats.users}</p>
        <p><strong>Total Events:</strong> {stats.events}</p>
      </div>
    </div>
  )
}
