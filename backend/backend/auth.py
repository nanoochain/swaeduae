from flask import Flask, request, jsonify
from flask_cors import CORS
import jwt
import datetime
from functools import wraps

app = Flask(__name__)
CORS(app)

app.config['SECRET_KEY'] = 'your-secret-key'

# Temporary in-memory storage
users = {
    "admin@swaeduae.ae": {"password": "adminpass", "role": "admin"},
    "user@swaeduae.ae": {"password": "userpass", "role": "user"}
}

events = [
    {"id": 1, "title": "Beach Cleanup", "date": "2025-08-01", "location": "Abu Dhabi"},
    {"id": 2, "title": "Food Drive", "date": "2025-08-10", "location": "Dubai"}
]

# ====================
# JWT Utilities
# ====================
def token_required(f):
    @wraps(f)
    def decorated(*args, **kwargs):
        token = request.headers.get('Authorization', None)
        if not token:
            return jsonify({"message": "Token is missing"}), 401
        try:
            token = token.split(" ")[1]
            data = jwt.decode(token, app.config['SECRET_KEY'], algorithms=["HS256"])
        except:
            return jsonify({"message": "Token is invalid"}), 401
        return f(data, *args, **kwargs)
    return decorated

# ====================
# AUTH ROUTES
# ====================
@app.route('/login', methods=['POST'])
def login():
    data = request.get_json()
    email = data.get('email')
    password = data.get('password')
    user = users.get(email)
    if user and user['password'] == password:
        token = jwt.encode({
            'email': email,
            'role': user['role'],
            'exp': datetime.datetime.utcnow() + datetime.timedelta(hours=8)
        }, app.config['SECRET_KEY'], algorithm="HS256")
        return jsonify({"token": token, "email": email, "role": user['role']})
    return jsonify({"message": "Invalid credentials"}), 401

# ====================
# PROFILE ROUTE
# ====================
@app.route('/profile', methods=['GET'])
@token_required
def profile(current_user):
    return jsonify({
        "email": current_user['email'],
        "role": current_user['role'],
        "name": "Volunteer User",
        "joined": "2025-07-01"
    })

# ====================
# GET EVENTS
# ====================
@app.route('/events', methods=['GET'])
def get_events():
    return jsonify(events)

# ====================
# ADMIN ADD EVENT
# ====================
@app.route('/admin/events', methods=['POST'])
@token_required
def add_event(current_user):
    if current_user['role'] != 'admin':
        return jsonify({"message": "Access denied"}), 403
    data = request.get_json()
    new_event = {
        "id": len(events) + 1,
        "title": data['title'],
        "date": data['date'],
        "location": data['location']
    }
    events.append(new_event)
    return jsonify(new_event), 201

# ====================
# SIGNUP ROUTE
# ====================
@app.route('/signup', methods=['POST'])
def signup():
    data = request.get_json()
    email = data.get('email')
    password = data.get('password')

    if not email or not password:
        return jsonify({"message": "Email and password are required"}), 400

    if email in users:
        return jsonify({"message": "User already exists"}), 400

    users[email] = {"password": password, "role": "user"}
    return jsonify({"message": "User registered successfully"}), 201


# ====================
# MAIN ENTRY
# ====================
if __name__ == '__main__':
    app.run(host='0.0.0.0', port=5000)

