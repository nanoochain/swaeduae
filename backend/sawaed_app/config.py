import os

class Config:
    SECRET_KEY = os.environ.get('SECRET_KEY', 'supersecret')
    SQLALCHEMY_DATABASE_URI = os.environ.get('DATABASE_URL', 'sqlite:///../instance/sawaeduae.db')
    SQLALCHEMY_TRACK_MODIFICATIONS = False
    JWT_SECRET_KEY = os.environ.get('JWT_SECRET_KEY', 'jwt-secret-key')
    UPLOAD_FOLDER = os.environ.get('UPLOAD_FOLDER', '../uploads')
    MAIL_SERVER = os.environ.get('MAIL_SERVER', 'smtp.tasjeel.ae')
    MAIL_PORT = int(os.environ.get('MAIL_PORT', 587))
    MAIL_USE_TLS = True
    MAIL_USERNAME = os.environ.get('MAIL_USERNAME', '')
    MAIL_PASSWORD = os.environ.get('MAIL_PASSWORD', '')
    ALLOWED_EXTENSIONS = {'pdf', 'png', 'jpg', 'jpeg', 'doc', 'docx'}
    # Add more configs as needed

