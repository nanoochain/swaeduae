#!/bin/bash
echo "🚀 Phase 5: Applying All Features"

# 1. Arabic Translations in i18n.js
echo "🌐 Adding Arabic translations..."
cd src
cat << 'EOT' > i18n.js
import i18n from 'i18next';
import { initReactI18next } from 'react-i18next';

i18n.use(initReactI18next).init({
  resources: {
    en: {
      translation: {
        "Sidebar": {
          "Title": "Sawaed UAE",
          "Dashboard": "Dashboard",
          "Profile": "Profile",
          "Certificates": "Certificates",
          "Volunteer": "Volunteer",
          "SwitchLang": "Switch Language",
          "Logout": "Logout"
        }
      }
    },
    ar: {
      translation: {
        "Sidebar": {
          "Title": "سواعد الإمارات",
          "Dashboard": "لوحة التحكم",
          "Profile": "الملف الشخصي",
          "Certificates": "الشهادات",
          "Volunteer": "المتطوع",
          "SwitchLang": "تغيير اللغة",
          "Logout": "تسجيل الخروج"
        }
      }
    }
  },
  lng: "en",
  fallbackLng: "en",
  interpolation: {
    escapeValue: false
  }
});

export default i18n;
EOT

# 2. Responsive UI (Tailwind breakpoints)
echo "📱 Applying responsive layout fixes..."
cat << 'EOT' > styles/responsive.css
/* Add Tailwind breakpoints */
@media (max-width: 768px) {
  .sidebar {
    display: none;
  }
}
EOT

# 3. Real-Time Stats via WebSocket (mocked frontend)
echo "📊 Enabling real-time dashboard updates..."
cd pages/Admin
cat << 'EOT' > AdminDashboard.jsx
import React, { useEffect, useState } from 'react';
import { useTranslation } from 'react-i18next';

const AdminDashboard = () => {
  const { t } = useTranslation();
  const [stats, setStats] = useState({ total_users: 0, total_events: 0 });

  useEffect(() => {
    const fetchStats = async () => {
      try {
        const res = await fetch('/admin/stats');
        const data = await res.json();
        if (data) setStats(data);
      } catch (err) {
        console.error('Error loading stats:', err);
      }
    };

    fetchStats();

    const socket = new WebSocket("wss://swaeduae.ae/ws/stats");
    socket.onmessage = (msg) => {
      const live = JSON.parse(msg.data);
      setStats(live);
    };

    return () => socket.close();
  }, []);

  return (
    <div className="p-4">
      <h1 className="text-2xl font-bold">{t("Sidebar.Dashboard")}</h1>
      <p><strong>Total Users:</strong> {stats.total_users}</p>
      <p><strong>Total Events:</strong> {stats.total_events}</p>
    </div>
  );
};

export default AdminDashboard;
EOT

# 4. KYC & Certificate UI (placeholder)
echo "🪪 Adding KYC & certificate upload..."
cat << 'EOT' > ../components/KYCUpload.jsx
import React from 'react';

const KYCUpload = () => (
  <div className="p-4">
    <h2>Upload KYC Documents</h2>
    <input type="file" />
    <button className="btn">Submit</button>
  </div>
);

export default KYCUpload;
EOT

# 5. Docker + PostgreSQL + Backend Migration
echo "🐘 Adding Docker and PostgreSQL setup..."
cd /opt/swaeduae
cat << 'EOT' > docker-compose.yml
version: "3.8"
services:
  web:
    build: ./backend
    ports:
      - "8000:8000"
    environment:
      - DATABASE_URL=postgresql://postgres:pass@db:5432/sawaed
  db:
    image: postgres:14
    environment:
      POSTGRES_USER=postgres
      POSTGRES_PASSWORD=pass
      POSTGRES_DB=sawaed
    volumes:
      - pgdata:/var/lib/postgresql/data
volumes:
  pgdata:
EOT

cat << 'EOT' > backend/Dockerfile
FROM python:3.11
WORKDIR /app
COPY . .
RUN pip install -r requirements.txt
CMD ["gunicorn", "-b", "0.0.0.0:8000", "sawaed_app:app"]
EOT

# 6. Frontend Validation & Tests
echo "🧪 Adding basic frontend validation and test config..."
cd /opt/swaeduae/frontend
cat << 'EOT' > vite.config.js
import { defineConfig } from 'vite'
import react from '@vitejs/plugin-react'

export default defineConfig({
  plugins: [react()],
  server: {
    host: true
  },
  test: {
    globals: true,
    environment: 'jsdom',
  }
})
EOT

# 7. .env and .gitignore
echo "🔐 Adding .env & .gitignore cleanup..."
cat << 'EOT' > .env
VITE_API_URL=https://swaeduae.ae
EOT

cat << 'EOT' > .gitignore
node_modules/
dist/
.env
*.log
*.sqlite3
__pycache__/
frontend/.env
backend/venv/
EOT

# 8. Admin Route Protection
echo "🛡️ Creating AdminRoute.jsx..."
cd src
cat << 'EOT' > components/AdminRoute.jsx
import React, { useContext } from "react";
import { Navigate } from "react-router-dom";
import { AuthContext } from "@/context/AuthContext";

const AdminRoute = ({ children }) => {
  const { user } = useContext(AuthContext);
  return user?.role === "admin" ? children : <Navigate to="/dashboard" />;
};

export default AdminRoute;
EOT

# Done
echo "✅ All Phase 5 features applied successfully!"
