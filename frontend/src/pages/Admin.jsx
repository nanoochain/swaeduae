import React from 'react'
import Sidebar from '../components/Sidebar'

export default function Admin() {
  return (
    <div className="flex">
      <Sidebar />
      <div className="p-8">
        <h1 className="text-2xl font-bold">Admin Panel</h1>
        <p>This is the protected admin panel. Future controls for managing users/events go here.</p>
      </div>
    </div>
  )
}
