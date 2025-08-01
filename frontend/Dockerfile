# Backend Dockerfile
FROM python:3.10-slim

WORKDIR /app

COPY backend/requirements.txt requirements.txt
RUN pip install -r requirements.txt

COPY backend /app/backend
WORKDIR /app/backend

CMD ["gunicorn", "-w", "4", "-b", "0.0.0.0:5000", "sawaed_app:app"]
