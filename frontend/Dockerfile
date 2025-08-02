# syntax=docker/dockerfile:1

## Frontend Dockerfile
# This multi‑stage image installs Node dependencies and builds the
# React application using Vite.  The resulting ``dist`` folder is
# copied to a shared volume in the docker-compose file.  The build
# stage uses a full Node base image while the final stage is
# minimal.

FROM node:18-alpine as build
WORKDIR /app

# Install dependencies based on package.json if present
COPY package*.json ./
RUN npm install --legacy-peer-deps

# Copy source files and build
COPY . .
RUN npm run build

# We don't define a default CMD here because the container is used
# solely during the build phase in docker-compose.  If you wish to
# develop locally without compose, you can run ``npm run dev``.