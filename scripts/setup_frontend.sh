#!/bin/bash
set -e

echo "🚀 Starting SawaedUAE Full Frontend Setup..."

# 1. package.json
cat > package.json << 'EOPKG'
{
  "name": "sawaed-frontend",
  "version": "1.0.0",
  "private": true,
  "scripts": {
    "dev": "vite",
    "build": "vite build",
    "preview": "vite preview"
  },
  "dependencies": {
    "axios": "^1.4.0",
    "react": "^18.2.0",
    "react-dom": "^18.2.0",
    "react-router-dom": "^6.14.1",
    "i18next": "^23.4.6",
    "react-i18next": "^13.0.2"
  },
  "devDependencies": {
    "@vitejs/plugin-react": "^4.0.0",
    "vite": "^4.5.14",
    "tailwindcss": "^3.3.2",
    "postcss": "^8.4.27",
    "autoprefixer": "^10.4.14"
  }
}
EOPKG

# 2. vite.config.js
cat > vite.config.js << 'EOVITE'
import { defineConfig } from 'vite'
import react from '@vitejs/plugin-react'

export default defineConfig({
  plugins: [react()],
  server: {
    host: true
  }
})
EOVITE

# 3. tailwind.config.js
cat > tailwind.config.js << 'EOTAIL'
/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./index.html",
    "./src/**/*.{js,jsx,ts,tsx}",
  ],
  theme: {
    extend: {},
  },
  plugins: [],
}
EOTAIL

# 4. postcss.config.js
cat > postcss.config.js << 'EOPOSTCSS'
module.exports = {
  plugins: {
    tailwindcss: {},
    autoprefixer: {},
  },
}
EOPOSTCSS

# 5. src/main.jsx
mkdir -p src
cat > src/main.jsx << 'EOMAIN'
import React from 'react'
import ReactDOM from 'react-dom/client'
import App from './App'
import './index.css'

ReactDOM.createRoot(document.getElementById('root')).render(
  <React.StrictMode>
    <App />
  </React.StrictMode>
)
EOMAIN

# 6. src/index.css
cat > src/index.css << 'EOSTYLE'
@tailwind base;
@tailwind components;
@tailwind utilities;
EOSTYLE

# 7. src/App.jsx
cat > src/App.jsx << 'EOAPP'
import React from 'react'
import { BrowserRouter as Router, Routes, Route } from 'react-router-dom'
import Home from './pages/Public/Home'
import Login from './pages/Auth/Login'
import Signup from './pages/Auth/Signup'
import EventsList from './pages/Volunteer/EventsList'
import EventDetail from './pages/Volunteer/EventDetail'
import Dashboard from './pages/Volunteer/Dashboard'
import CertificateViewer from './pages/Volunteer/CertificateViewer'
import AdminDashboard from './pages/Admin/AdminDashboard'
import AdminUserList from './pages/Admin/AdminUserList'
import AdminEventList from './pages/Admin/AdminEventList'
import AdminCertApprove from './pages/Admin/AdminCertApprove'
import PrivateRoute from './components/PrivateRoute'
import AdminRoute from './components/AdminRoute'
import { AuthProvider } from './context/AuthContext'

function App() {
  return (
    <AuthProvider>
      <Router>
        <Routes>
          {/* Public */}
          <Route path="/" element={<Home />} />
          <Route path="/login" element={<Login />} />
          <Route path="/signup" element={<Signup />} />

          {/* Volunteer Auth Routes */}
          <Route element={<PrivateRoute />}>
            <Route path="/events" element={<EventsList />} />
            <Route path="/events/:id" element={<EventDetail />} />
            <Route path="/dashboard" element={<Dashboard />} />
            <Route path="/certificates" element={<CertificateViewer />} />
          </Route>

          {/* Admin Routes */}
          <Route element={<AdminRoute />}>
            <Route path="/admin" element={<AdminDashboard />} />
            <Route path="/admin/users" element={<AdminUserList />} />
            <Route path="/admin/events" element={<AdminEventList />} />
            <Route path="/admin/certificates" element={<AdminCertApprove />} />
          </Route>

          {/* Fallback */}
          <Route path="*" element={<Home />} />
        </Routes>
      </Router>
    </AuthProvider>
  )
}

export default App
EOAPP

# 8. src/context/AuthContext.jsx
mkdir -p src/context
cat > src/context/AuthContext.jsx << 'EOAUTHCTX'
import React, { createContext, useState, useEffect } from 'react'
import { useNavigate } from 'react-router-dom'
import api from '../services/api'

export const AuthContext = createContext()

export const AuthProvider = ({ children }) => {
  const navigate = useNavigate()
  const [user, setUser] = useState(null)
  const [token, setToken] = useState(localStorage.getItem('token') || null)

  useEffect(() => {
    if(token) {
      // fetch user profile or decode token here
      setUser({ loggedIn: true })
    } else {
      setUser(null)
    }
  }, [token])

  const login = async (email, password) => {
    try {
      const data = await api.login(email, password)
      localStorage.setItem('token', data.token)
      setToken(data.token)
      navigate('/dashboard')
    } catch (err) {
      throw err
    }
  }

  const logout = () => {
    localStorage.removeItem('token')
    setToken(null)
    setUser(null)
    navigate('/login')
  }

  const signup = async (username, email, password) => {
    try {
      await api.signup(username, email, password)
      navigate('/login')
    } catch (err) {
      throw err
    }
  }

  return (
    <AuthContext.Provider value={{ user, token, login, logout, signup }}>
      {children}
    </AuthContext.Provider>
  )
}
EOAUTHCTX

# 9. src/components/PrivateRoute.jsx
mkdir -p src/components
cat > src/components/PrivateRoute.jsx << 'EOPRIV'
import React, { useContext } from 'react'
import { Navigate, Outlet } from 'react-router-dom'
import { AuthContext } from '../context/AuthContext'

export default function PrivateRoute() {
  const { user } = useContext(AuthContext)
  if (!user) {
    return <Navigate to="/login" />
  }
  return <Outlet />
}
EOPRIV

# 10. src/components/AdminRoute.jsx
cat > src/components/AdminRoute.jsx << 'EOADMIN'
import React, { useContext } from 'react'
import { Navigate, Outlet } from 'react-router-dom'
import { AuthContext } from '../context/AuthContext'

export default function AdminRoute() {
  const { user } = useContext(AuthContext)
  if (!user || user.role !== 'admin') {
    return <Navigate to="/login" />
  }
  return <Outlet />
}
EOADMIN

# 11. src/services/api.js
cat > src/services/api.js << 'EOAPI'
import axios from 'axios'

const API_BASE = '/'

const instance = axios.create({
  baseURL: API_BASE,
  headers: { 'Content-Type': 'application/json' },
})

export async function login(email, password) {
  const res = await instance.post('/auth/login', { email, password })
  return res.data
}

export async function signup(username, email, password) {
  const res = await instance.post('/auth/signup', { username, email, password })
  return res.data
}

export async function getEvents() {
  const res = await instance.get('/events')
  return res.data
}

export async function getEvent(id) {
  const res = await instance.get(`/events/${id}`)
  return res.data
}

export async function registerForEvent(event_id) {
  const res = await instance.post('/events/register', { event_id })
  return res.data
}

export async function getCertificates() {
  const res = await instance.get('/certificates')
  return res.data
}

// Add more API functions as needed...

export default {
  login,
  signup,
  getEvents,
  getEvent,
  registerForEvent,
  getCertificates,
}
EOAPI

# 12. src/pages/Public/Home.jsx
mkdir -p src/pages/Public
cat > src/pages/Public/Home.jsx << 'EOHOME'
import React from 'react'
import { Link } from 'react-router-dom'

export default function Home() {
  return (
    <div className="min-h-screen flex flex-col items-center justify-center p-4 bg-gradient-to-r from-blue-400 to-indigo-600 text-white">
      <h1 className="text-5xl font-bold mb-4">Welcome to Sawaed UAE</h1>
      <p className="text-xl mb-8 max-w-xl text-center">
        Volunteer, connect, and make a difference across the Emirates.
      </p>
      <div className="space-x-4">
        <Link to="/signup" className="px-6 py-3 bg-white text-indigo-700 font-semibold rounded shadow hover:bg-indigo-100">Sign Up</Link>
        <Link to="/login" className="px-6 py-3 border border-white font-semibold rounded hover:bg-indigo-700 hover:text-white">Log In</Link>
      </div>
    </div>
  )
}
EOHOME

# 13. src/pages/Auth/Login.jsx
mkdir -p src/pages/Auth
cat > src/pages/Auth/Login.jsx << 'EOLOGIN'
import React, { useState, useContext } from 'react'
import { AuthContext } from '../../context/AuthContext'

export default function Login() {
  const { login } = useContext(AuthContext)
  const [email, setEmail] = useState('')
  const [password, setPassword] = useState('')
  const [error, setError] = useState(null)

  const handleSubmit = async e => {
    e.preventDefault()
    try {
      await login(email, password)
    } catch (err) {
      setError('Invalid credentials')
    }
  }

  return (
    <div className="min-h-screen flex items-center justify-center bg-gray-50 p-4">
      <form onSubmit={handleSubmit} className="bg-white p-6 rounded shadow-md w-full max-w-sm">
        <h2 className="text-2xl mb-6 font-semibold">Log In</h2>
        {error && <div className="mb-4 text-red-600">{error}</div>}
        <label className="block mb-2">Email</label>
        <input type="email" className="border p-2 mb-4 w-full" value={email} onChange={e => setEmail(e.target.value)} required />
        <label className="block mb-2">Password</label>
        <input type="password" className="border p-2 mb-6 w-full" value={password} onChange={e => setPassword(e.target.value)} required />
        <button type="submit" className="w-full bg-indigo-600 text-white py-2 rounded hover:bg-indigo-700">Log In</button>
      </form>
    </div>
  )
}
EOLOGIN

# 14. src/pages/Auth/Signup.jsx
cat > src/pages/Auth/Signup.jsx << 'EOSIGNUP'
import React, { useState, useContext } from 'react'
import { AuthContext } from '../../context/AuthContext'

export default function Signup() {
  const { signup } = useContext(AuthContext)
  const [username, setUsername] = useState('')
  const [email, setEmail] = useState('')
  const [password, setPassword] = useState('')
  const [error, setError] = useState(null)
  const [success, setSuccess] = useState(null)

  const handleSubmit = async e => {
    e.preventDefault()
    try {
      await signup(username, email, password)
      setSuccess('Signup successful! Please log in.')
    } catch (err) {
      setError('Failed to sign up')
    }
  }

  return (
    <div className="min-h-screen flex items-center justify-center bg-gray-50 p-4">
      <form onSubmit={handleSubmit} className="bg-white p-6 rounded shadow-md w-full max-w-sm">
        <h2 className="text-2xl mb-6 font-semibold">Sign Up</h2>
        {error && <div className="mb-4 text-red-600">{error}</div>}
        {success && <div className="mb-4 text-green-600">{success}</div>}
        <label className="block mb-2">Username</label>
        <input type="text" className="border p-2 mb-4 w-full" value={username} onChange={e => setUsername(e.target.value)} required />
        <label className="block mb-2">Email</label>
        <input type="email" className="border p-2 mb-4 w-full" value={email} onChange={e => setEmail(e.target.value)} required />
        <label className="block mb-2">Password</label>
        <input type="password" className="border p-2 mb-6 w-full" value={password} onChange={e => setPassword(e.target.value)} required />
        <button type="submit" className="w-full bg-indigo-600 text-white py-2 rounded hover:bg-indigo-700">Sign Up</button>
      </form>
    </div>
  )
}
EOSIGNUP

# 15. src/pages/Volunteer/EventsList.jsx
mkdir -p src/pages/Volunteer
cat > src/pages/Volunteer/EventsList.jsx << 'EOEVENTSLIST'
import React, { useEffect, useState } from 'react'
import { getEvents } from '../../services/api'
import { Link } from 'react-router-dom'

export default function EventsList() {
  const [events, setEvents] = useState([])

  useEffect(() => {
    getEvents().then(setEvents)
  }, [])

  return (
    <div className="p-4 max-w-4xl mx-auto">
      <h1 className="text-3xl font-semibold mb-4">Upcoming Volunteer Events</h1>
      {events.length === 0 ? (
        <p>No upcoming events.</p>
      ) : (
        <ul className="space-y-4">
          {events.map(event => (
            <li key={event.id} className="border p-4 rounded shadow hover:shadow-lg transition">
              <Link to={`/events/${event.id}`} className="block">
                <h2 className="text-xl font-bold">{event.title}</h2>
                <p>{event.date}</p>
                <p>{event.location}</p>
              </Link>
            </li>
          ))}
        </ul>
      )}
    </div>
  )
}
EOEVENTSLIST

# 16. src/pages/Volunteer/EventDetail.jsx
cat > src/pages/Volunteer/EventDetail.jsx << 'EOEVENTDETAIL'
import React, { useEffect, useState } from 'react'
import { getEvent, registerForEvent } from '../../services/api'
import { useParams } from 'react-router-dom'

export default function EventDetail() {
  const { id } = useParams()
  const [event, setEvent] = useState(null)
  const [message, setMessage] = useState('')

  useEffect(() => {
    getEvent(id).then(setEvent)
  }, [id])

  const handleRegister = async () => {
    try {
      await registerForEvent(id)
      setMessage('Successfully registered for event!')
    } catch {
      setMessage('Failed to register for event.')
    }
  }

  if (!event) return <p>Loading...</p>

  return (
    <div className="p-4 max-w-3xl mx-auto">
      <h1 className="text-3xl font-bold mb-2">{event.title}</h1>
      <p className="mb-2">{event.date}</p>
      <p className="mb-2">{event.location}</p>
      <p className="mb-4">{event.description}</p>
      <button
        onClick={handleRegister}
        className="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700"
      >
        Register
      </button>
      {message && <p className="mt-4">{message}</p>}
    </div>
  )
}
EOEVENTDETAIL

# 17. src/pages/Volunteer/Dashboard.jsx
cat > src/pages/Volunteer/Dashboard.jsx << 'EODASH'
import React from 'react'

export default function Dashboard() {
  return (
    <div className="p-4 max-w-4xl mx-auto">
      <h1 className="text-3xl font-semibold mb-4">Volunteer Dashboard</h1>
      <p>Welcome to your dashboard. Features coming soon!</p>
    </div>
  )
}
EODASH

# 18. src/pages/Volunteer/CertificateViewer.jsx
cat > src/pages/Volunteer/CertificateViewer.jsx << 'EOCERTVIEW'
import React from 'react'

export default function CertificateViewer() {
  return (
    <div className="p-4 max-w-4xl mx-auto">
      <h1 className="text-3xl font-semibold mb-4">Your Certificates</h1>
      <p>Certificate viewer coming soon!</p>
    </div>
  )
}
EOCERTVIEW

# 19. src/pages/Admin/AdminDashboard.jsx
mkdir -p src/pages/Admin
cat > src/pages/Admin/AdminDashboard.jsx << 'EOADMINDASH'
import React from 'react'

export default function AdminDashboard() {
  return (
    <div className="p-4 max-w-5xl mx-auto">
      <h1 className="text-3xl font-semibold mb-4">Admin Dashboard</h1>
      <p>Admin features coming soon!</p>
    </div>
  )
}
EOADMINDASH

# 20. src/pages/Admin/AdminUserList.jsx
cat > src/pages/Admin/AdminUserList.jsx << 'EOADMINUSER'
import React from 'react'

export default function AdminUserList() {
  return (
    <div className="p-4 max-w-5xl mx-auto">
      <h1 className="text-3xl font-semibold mb-4">User Management</h1>
      <p>List of users and management features coming soon!</p>
    </div>
  )
}
EOADMINUSER

# 21. src/pages/Admin/AdminEventList.jsx
cat > src/pages/Admin/AdminEventList.jsx << 'EOADMINEVENTS'
import React from 'react'

export default function AdminEventList() {
  return (
    <div className="p-4 max-w-5xl mx-auto">
      <h1 className="text-3xl font-semibold mb-4">Event Management</h1>
      <p>Manage events here. Coming soon!</p>
    </div>
  )
}
EOADMINEVENTS

# 22. src/pages/Admin/AdminCertApprove.jsx
cat > src/pages/Admin/AdminCertApprove.jsx << 'EOADMINCERT'
import React from 'react'

export default function AdminCertApprove() {
  return (
    <div className="p-4 max-w-5xl mx-auto">
      <h1 className="text-3xl font-semibold mb-4">Certificate Approvals</h1>
      <p>Certificate approval features coming soon!</p>
    </div>
  )
}
EOADMINCERT

echo "✅ Frontend files created/updated."

echo "👉 Run 'npm install' inside /opt/swaeduae/frontend to install dependencies."
echo "👉 Then run 'npm run dev' to start the dev server or 'npm run build' to build for production."

