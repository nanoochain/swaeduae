import React, { useEffect, useState } from 'react'
import axios from 'axios'
import { useAuth } from '../context/AuthContext'
import QRCode from 'react-qr-code'

const CertificateViewer = () => {
  const { user } = useAuth()
  const [cert, setCert] = useState(null)

  useEffect(() => {
    if (!user?.id) return
    axios.get(`/certificates/user/${user.id}`)
      .then(res => setCert(res.data))
      .catch(err => console.error(err))
  }, [user])

  if (!cert) return <p>Loading certificate...</p>

  return (
    <div className="max-w-xl mx-auto bg-white shadow p-6 rounded">
      <h2 className="text-2xl font-bold mb-4">Certificate</h2>
      <p><strong>Name:</strong> {cert.name}</p>
      <p><strong>Event:</strong> {cert.event_title}</p>
      <p><strong>Date:</strong> {cert.date}</p>
      <div className="my-4">
        <QRCode value={`https://swaeduae.ae/verify/${cert.id}`} />
        <p className="text-sm mt-2 text-gray-600">Scan to verify</p>
      </div>
    </div>
  )
}

export default CertificateViewer
