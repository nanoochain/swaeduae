# syntax=docker/dockerfile:1

## Backend Dockerfile
# This image installs Python dependencies, copies the source code and
# launches the application with Gunicorn.  Using a slim Python base
# keeps the image size small.  Adjust the Python version as needed.

FROM python:3.11-slim as base
ENV PYTHONDONTWRITEBYTECODE=1
ENV PYTHONUNBUFFERED=1

WORKDIR /app

# Install dependencies
COPY requirements.txt .
RUN pip install --no-cache-dir -r requirements.txt

# Copy application code
COPY . .

# Default command.  When using docker-compose this is overridden in the
# service definition to specify the app factory path.
CMD ["gunicorn", "--workers", "4", "--bind", "0.0.0.0:5000", "sawaed_app:create_app()"]