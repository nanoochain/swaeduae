from flask import Blueprint, request, jsonify
from flask_jwt_extended import create_access_token
from sawaed_app import db

auth_bp = Blueprint("auth", __name__)

@auth_bp.route("/signup", methods=["POST"])
def signup():
    from sawaed_app.models import User
    data = request.get_json()
    email = data.get("email")
    username = data.get("username")
    password = data.get("password")

    if User.query.filter_by(email=email).first():
        return jsonify({"msg": "Email already exists"}), 400

    new_user = User(email=email, username=username, password=password, role='user')
    db.session.add(new_user)
    db.session.commit()

    return jsonify({"message": "User registered", "email": email})

@auth_bp.route("/login", methods=["POST"])
def login():
    from sawaed_app.models import User
    data = request.get_json()
    email = data.get("email")
    password = data.get("password")

    user = User.query.filter_by(email=email).first()
    if not user or user.password != password:
        return jsonify({"msg": "Invalid credentials"}), 401

    token = create_access_token(identity={"id": user.id, "role": user.role})
    return jsonify(access_token=token), 200
