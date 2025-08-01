#!/bin/bash

# Phase 8: Volunteer Hours, Badges, Org Admin, Whistleblowing, Mobile Polish

cd /opt/swaeduae/frontend/src/components
nano VolunteerHoursTracker.jsx <<'EOF'
import React, { useEffect, useState } from "react";
import { getVolunteerHours, logVolunteerHours } from "@/services/api";
import { useAuth } from "@/context/AuthContext";
export default function VolunteerHoursTracker() {
  const { user } = useAuth();
  const [hours, setHours] = useState([]);
  const [total, setTotal] = useState(0);
  const [event, setEvent] = useState("");
  const [loggedHours, setLoggedHours] = useState("");
  const [message, setMessage] = useState("");
  useEffect(() => {
    if (user) {
      getVolunteerHours(user.id).then(data => {
        setHours(data?.logs || []);
        setTotal(data?.total || 0);
      });
    }
  }, [user]);
  const handleLog = async (e) => {
    e.preventDefault();
    if (!event || !loggedHours) return setMessage("All fields required");
    const res = await logVolunteerHours(user.id, { event, hours: Number(loggedHours) });
    setMessage(res.message || "Hours logged!");
    getVolunteerHours(user.id).then(data => {
      setHours(data?.logs || []);
      setTotal(data?.total || 0);
    });
    setEvent(""); setLoggedHours("");
  };
  return (
    <div className="bg-white dark:bg-gray-900 p-6 rounded-2xl shadow mb-6 max-w-xl mx-auto">
      <h2 className="text-xl font-bold mb-2">⏱️ Volunteer Hours</h2>
      <form onSubmit={handleLog} className="flex flex-col sm:flex-row gap-2 mb-2">
        <input className="input input-bordered flex-1" placeholder="Event Name" value={event} onChange={e=>setEvent(e.target.value)} />
        <input className="input input-bordered w-24" type="number" min={0.5} step={0.5} placeholder="Hours" value={loggedHours} onChange={e=>setLoggedHours(e.target.value)} />
        <button className="btn btn-primary" type="submit">Log</button>
      </form>
      {message && <div className="text-green-600 mb-2">{message}</div>}
      <div className="text-sm mb-2">Total Hours: <b>{total}</b></div>
      <ul className="max-h-32 overflow-y-auto text-xs">
        {hours.map((h,i) => (
          <li key={i} className="border-b py-1">{h.date}: {h.event} - <b>{h.hours}h</b></li>
        ))}
      </ul>
    </div>
  );
}
EOF

nano VolunteerBadges.jsx <<'EOF'
import React, { useEffect, useState } from "react";
import { getVolunteerBadges } from "@/services/api";
import { useAuth } from "@/context/AuthContext";
const BADGES = [
  { threshold: 10, label: "Bronze Helper", emoji: "🥉" },
  { threshold: 25, label: "Silver Contributor", emoji: "🥈" },
  { threshold: 50, label: "Gold Volunteer", emoji: "🥇" },
  { threshold: 100, label: "Platinum Service", emoji: "🏆" },
];
export default function VolunteerBadges() {
  const { user } = useAuth();
  const [badges, setBadges] = useState([]);
  useEffect(() => {
    if (user) getVolunteerBadges(user.id).then(setBadges);
  }, [user]);
  return (
    <div className="bg-white dark:bg-gray-900 p-6 rounded-2xl shadow mb-6 max-w-xl mx-auto">
      <h2 className="text-xl font-bold mb-2">🏅 Badges & Impact</h2>
      <div className="flex gap-3 flex-wrap items-center mb-2">
        {BADGES.map(b => (
          <span key={b.label} className={badges.includes(b.label) ? "opacity-100" : "opacity-40"}>
            <span className="text-3xl">{b.emoji}</span><br />
            <span className="text-xs">{b.label}</span>
          </span>
        ))}
      </div>
      <div className="text-sm">
        <b>{badges.length}</b> badges earned.
      </div>
    </div>
  );
}
EOF

nano OrgAdminPortal.jsx <<'EOF'
import React, { useEffect, useState } from "react";
import { getOrgApplicants, approveApplicant, rejectApplicant } from "@/services/api";
import { useAuth } from "@/context/AuthContext";
export default function OrgAdminPortal() {
  const { user } = useAuth();
  const [applicants, setApplicants] = useState([]);
  useEffect(() => {
    if (user?.role === "org_admin") getOrgApplicants(user.orgId).then(setApplicants);
  }, [user]);
  const handleApprove = async (id) => {
    await approveApplicant(id); setApplicants(applicants => applicants.filter(a=>a.id!==id));
  };
  const handleReject = async (id) => {
    await rejectApplicant(id); setApplicants(applicants => applicants.filter(a=>a.id!==id));
  };
  if (user?.role !== "org_admin") return <div className="p-6">Access denied</div>;
  return (
    <div className="bg-white dark:bg-gray-900 p-6 rounded-2xl shadow max-w-3xl mx-auto">
      <h2 className="text-xl font-bold mb-4">🧑‍💼 Manage Applicants</h2>
      {applicants.length === 0 ? <div>No pending applicants.</div> : (
        <table className="w-full text-sm">
          <thead><tr><th>Name</th><th>Email</th><th>Event</th><th></th></tr></thead>
          <tbody>
            {applicants.map(a=>(
              <tr key={a.id} className="border-b">
                <td>{a.name}</td>
                <td>{a.email}</td>
                <td>{a.event}</td>
                <td>
                  <button className="btn btn-success btn-xs mr-1" onClick={()=>handleApprove(a.id)}>Approve</button>
                  <button className="btn btn-error btn-xs" onClick={()=>handleReject(a.id)}>Reject</button>
                </td>
              </tr>
            ))}
          </tbody>
        </table>
      )}
    </div>
  );
}
EOF

nano WhistleblowingForm.jsx <<'EOF'
import React, { useState } from "react";
import { submitWhistleblow } from "@/services/api";
export default function WhistleblowingForm() {
  const [text, setText] = useState("");
  const [msg, setMsg] = useState("");
  const [loading, setLoading] = useState(false);
  const handleSubmit = async (e) => {
    e.preventDefault();
    setLoading(true); setMsg("");
    const res = await submitWhistleblow(text);
    setMsg(res.message || "Submitted");
    setText(""); setLoading(false);
  };
  return (
    <div className="bg-white dark:bg-gray-900 p-6 rounded-2xl shadow max-w-lg mx-auto mt-8">
      <h2 className="text-xl font-bold mb-2">📣 Whistleblowing Form</h2>
      <form onSubmit={handleSubmit}>
        <textarea className="input input-bordered w-full h-28 mb-2" placeholder="Describe your concern (confidential)" value={text} onChange={e=>setText(e.target.value)} />
        <button className="btn btn-warning w-full" type="submit" disabled={loading || !text}>{loading ? "Sending..." : "Submit"}</button>
      </form>
      {msg && <div className="text-green-700 mt-2">{msg}</div>}
    </div>
  );
}
EOF

# Add API service stubs for new features
cd /opt/swaeduae/frontend/src/services
nano api.js <<'EOF'
import axios from 'axios';
const API = import.meta.env.VITE_API_URL || "https://swaeduae.ae";

// --- Volunteer Hours ---
export const getVolunteerHours = async (userId) => {
  const res = await axios.get(`${API}/volunteer/${userId}/hours`);
  return res.data;
};
export const logVolunteerHours = async (userId, data) => {
  const res = await axios.post(`${API}/volunteer/${userId}/hours`, data);
  return res.data;
};

// --- Badges ---
export const getVolunteerBadges = async (userId) => {
  const res = await axios.get(`${API}/volunteer/${userId}/badges`);
  return res.data.badges || [];
};

// --- Org Admin Applicants ---
export const getOrgApplicants = async (orgId) => {
  const res = await axios.get(`${API}/org/${orgId}/applicants`);
  return res.data.applicants || [];
};
export const approveApplicant = async (id) => {
  const res = await axios.post(`${API}/org/applicant/${id}/approve`);
  return res.data;
};
export const rejectApplicant = async (id) => {
  const res = await axios.post(`${API}/org/applicant/${id}/reject`);
  return res.data;
};

// --- Whistleblowing ---
export const submitWhistleblow = async (text) => {
  const res = await axios.post(`${API}/whistleblow`, { text });
  return res.data;
};
EOF

# Pages integration
cd /opt/swaeduae/frontend/src/pages
nano Dashboard.jsx <<'EOF'
import React from "react";
import VolunteerHoursTracker from "@/components/VolunteerHoursTracker";
import VolunteerBadges from "@/components/VolunteerBadges";
export default function Dashboard() {
  return (
    <div className="py-6 px-2 max-w-4xl mx-auto">
      <h1 className="text-2xl font-bold mb-4">📊 Dashboard</h1>
      <div className="flex flex-col md:flex-row gap-4">
        <div className="flex-1">
          <VolunteerHoursTracker />
          <VolunteerBadges />
        </div>
        {/* You can add more stats/cards here */}
      </div>
    </div>
  );
}
EOF

nano OrgAdmin.jsx <<'EOF'
import React from "react";
import OrgAdminPortal from "@/components/OrgAdminPortal";
export default function OrgAdmin() {
  return (
    <div className="py-6 px-2">
      <OrgAdminPortal />
    </div>
  );
}
EOF

nano Whistleblow.jsx <<'EOF'
import React from "react";
import WhistleblowingForm from "@/components/WhistleblowingForm";
export default function Whistleblow() {
  return (
    <div className="py-6 px-2">
      <WhistleblowingForm />
    </div>
  );
}
EOF

# Routing updates
cd /opt/swaeduae/frontend/src
nano App.jsx <<'EOF'
import React from "react";
import { BrowserRouter as Router, Routes, Route } from "react-router-dom";
import Dashboard from "@/pages/Dashboard";
import OrgAdmin from "@/pages/OrgAdmin";
import Whistleblow from "@/pages/Whistleblow";
// ...other imports
export default function App() {
  return (
    <Router>
      {/* ...Navbar etc */}
      <Routes>
        <Route path="/dashboard" element={<Dashboard />} />
        <Route path="/org-admin" element={<OrgAdmin />} />
        <Route path="/whistleblow" element={<Whistleblow />} />
        {/* ...other routes */}
      </Routes>
    </Router>
  );
}
EOF

# Navbar: add new links (OrgAdmin, Whistleblow)
cd /opt/swaeduae/frontend/src/components
nano Navbar.jsx <<'EOF'
import React from "react";
import { Link } from "react-router-dom";
import { useAuth } from "@/context/AuthContext";
export default function Navbar() {
  const { user } = useAuth();
  return (
    <nav className="bg-primary text-white px-4 py-2 flex items-center justify-between">
      <div>
        <Link className="font-bold text-lg" to="/dashboard">SawaedUAE</Link>
      </div>
      <div className="flex gap-3 items-center">
        <Link to="/dashboard" className="hover:underline">Dashboard</Link>
        <Link to="/whistleblow" className="hover:underline">Whistleblow</Link>
        {user?.role === "org_admin" && <Link to="/org-admin" className="hover:underline">Org Admin</Link>}
        {/* ...more links */}
        <Link to="/profile" className="hover:underline">Profile</Link>
      </div>
    </nav>
  );
}
EOF

# Mobile responsiveness polish: Tailwind tweaks & responsive layouts
# (Assuming Tailwind is configured)
cd /opt/swaeduae/frontend/src/styles
nano index.css <<'EOF'
@tailwind base;
@tailwind components;
@tailwind utilities;

body {
  @apply bg-gray-100 dark:bg-gray-800 min-h-screen;
}

input, textarea, .input {
  @apply rounded-xl border border-gray-300 p-2 text-base;
}

.btn {
  @apply px-4 py-2 rounded-xl font-bold shadow;
}
@media (max-width: 640px) {
  .max-w-xl, .max-w-3xl, .max-w-4xl { max-width: 100% !important; }
  .flex-row, .md\:flex-row { flex-direction: column !important; }
  .px-2, .p-6 { padding-left: 0.5rem; padding-right: 0.5rem; }
}
EOF

cd /opt/swaeduae/frontend
git add .
git commit -am "🚀 Phase 8: Volunteer hours, badges, org admin portal, whistleblowing, mobile polish"
git push

echo ""
echo "✅ Phase 8 components and routing added!"
echo "Next:"
echo " 1. npm run build"
echo " 2. sudo cp -r dist/* /var/www/swaeduae.ae/html/"
echo " 3. sudo systemctl reload nginx"
echo ""
echo "Git remote reminder:"
echo "  git remote set-url origin git@github.com:nanoochain/swaeduae.git"
