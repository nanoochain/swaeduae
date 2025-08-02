from functools import wraps
from flask import request, jsonify
from ..models import User
import jwt
import os

def admin_required(f):
    @wraps(f)
    def decorated(*args, **kwargs):
        token = None
        if 'Authorization' in request.headers:
            token = request.headers['Authorization'].split(" ")[1]

        if not token:
            return jsonify({'message': 'Token is missing!'}), 401

        try:
            data = jwt.decode(token, os.getenv("JWT_SECRET", "secret"), algorithms=["HS256"])
            user = User.query.filter_by(id=data['user_id']).first()
            if user.role != 'admin':
                return jsonify({'message': 'Admins only!'}), 403
        except:
            return jsonify({'message': 'Token is invalid!'}), 401

        return f(*args, **kwargs)

    return decorated
