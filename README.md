<<<<<<< HEAD
# React + Vite

This template provides a minimal setup to get React working in Vite with HMR and some ESLint rules.

Currently, two official plugins are available:

- [@vitejs/plugin-react](https://github.com/vitejs/vite-plugin-react/blob/main/packages/plugin-react) uses [Babel](https://babeljs.io/) for Fast Refresh
- [@vitejs/plugin-react-swc](https://github.com/vitejs/vite-plugin-react/blob/main/packages/plugin-react-swc) uses [SWC](https://swc.rs/) for Fast Refresh

## Expanding the ESLint configuration

If you are developing a production application, we recommend using TypeScript with type-aware lint rules enabled. Check out the [TS template](https://github.com/vitejs/vite/tree/main/packages/create-vite/template-react-ts) for information on how to integrate TypeScript and [`typescript-eslint`](https://typescript-eslint.io) in your project.
=======
# SawaedUAE Volunteer Platform 🇦🇪

A modern full-stack platform for volunteer management, built for Sawaed Emirates Volunteer Society.

## Features

- 🔐 JWT-based authentication
- 🌍 Multilingual: Arabic 🇦🇪 + English 🇬🇧
- 🗓️ Volunteer event registration
- 🧾 Certificate viewer + QR verification
- 🧑‍💼 Admin dashboard
- 📦 Dockerized backend/frontend
- 🚀 CI/CD via GitHub Actions

## Tech Stack

- Backend: Python (Flask) + PostgreSQL
- Frontend: React + Vite + Tailwind CSS
- Deployment: Docker + Gunicorn + Nginx

## Setup

```bash
# Backend
cd backend
cp .env.example .env
docker-compose up --build

# Frontend
cd frontend
npm install
npm run dev
```

> Production-ready deployment runs via Docker + Nginx + Gunicorn
>>>>>>> 4267a6b (✅ Final Phase 3: API fixes, dashboard polish, final prep)
