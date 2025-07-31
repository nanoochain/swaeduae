# /opt/swaeduae/backend/config.py

class Config:
    SECRET_KEY = "supersecretkey"
    SQLALCHEMY_DATABASE_URI = "sqlite:///instance/database.db"
    SQLALCHEMY_TRACK_MODIFICATIONS = False
