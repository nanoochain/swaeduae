from flask import Blueprint, request, jsonify
from flask_jwt_extended import (
    create_access_token,
    create_refresh_token,
    jwt_required,
    get_jwt_identity,
)
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

    # Generate a fresh access token and a refresh token.  The access token is
    # short‑lived and used on each request; the refresh token can be exchanged
    # for a new access token without requiring credentials again.  The refresh
    # token is marked as non‑fresh.
    access_token = create_access_token(identity={"id": user.id, "role": user.role}, fresh=True)
    refresh_token = create_refresh_token(identity={"id": user.id, "role": user.role})
    return jsonify(access_token=access_token, refresh_token=refresh_token), 200


@auth_bp.route("/refresh", methods=["POST"])
@jwt_required(refresh=True)
def refresh():
    """Exchange a refresh token for a new access token.

    Clients must send the refresh token in the Authorization header as a Bearer
    token.  Upon success a new (non‑fresh) access token is returned.  See
    https://flask-jwt-extended.readthedocs.io/ for details.
    """
    identity = get_jwt_identity()
    new_access_token = create_access_token(identity=identity)
    return jsonify(access_token=new_access_token), 200


@auth_bp.route("/uae_pass_login", methods=["POST"])
def uae_pass_login():
    """Placeholder endpoint for UAE PASS login.

    In a future phase this endpoint will integrate with the UAE PASS OAuth
    provider to authenticate users using their national digital identity.  For
    now it simply returns an informative 501 status code.
    """
    return jsonify({"msg": "UAE PASS login is not implemented yet"}), 501
