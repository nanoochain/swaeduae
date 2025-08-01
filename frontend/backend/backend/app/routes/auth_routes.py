# /opt/swaeduae/backend/app/routes/auth_routes.py

from flask import Blueprint, request, jsonify
from app.models import db, User

auth_bp = Blueprint("auth", __name__)

@auth_bp.route("/signup", methods=["POST"])
def signup():
    data = request.json
    if User.query.filter_by(email=data["email"]).first():
        return jsonify({"message": "User already exists"}), 400
    new_user = User(email=data["email"], password=data["password"])
    db.session.add(new_user)
    db.session.commit()
    return jsonify({"message": "User created"}), 201

@auth_bp.route("/login", methods=["POST"])
def login():
    data = request.json
    user = User.query.filter_by(email=data["email"], password=data["password"]).first()
    if not user:
        return jsonify({"message": "Invalid credentials"}), 401
    return jsonify({"message": "Login successful", "email": user.email})
