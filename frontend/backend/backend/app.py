from flask import Flask, request, jsonify
from flask_sqlalchemy import SQLAlchemy
from flask_cors import CORS

app = Flask(__name__)
CORS(app)

app.config['SQLALCHEMY_DATABASE_URI'] = 'sqlite:///swaeduae.db'
app.config['SQLALCHEMY_TRACK_MODIFICATIONS'] = False

db = SQLAlchemy(app)

class User(db.Model):
    id = db.Column(db.Integer, primary_key=True)
    email = db.Column(db.String(120), unique=True, nullable=False)
    password = db.Column(db.String(120), nullable=False)
    role = db.Column(db.String(20), default="user")
    otp = db.Column(db.String(10), default="000000")

class Event(db.Model):
    id = db.Column(db.Integer, primary_key=True)
    title = db.Column(db.String(120))
    date = db.Column(db.String(30))

@app.route('/signup', methods=['POST'])
def signup():
    data = request.json
    if User.query.filter_by(email=data['email']).first():
        return jsonify({"message": "User already exists"}), 400
    user = User(email=data['email'], password=data['password'], otp="123456", role="user")
    db.session.add(user)
    db.session.commit()
    return jsonify({"message": "User registered"}), 201

@app.route('/login', methods=['POST'])
def login():
    data = request.json
    user = User.query.filter_by(email=data['email'], password=data['password'], otp=data['otp']).first()
    if user:
        return jsonify({"token": "mock-jwt-token", "role": user.role})
    return jsonify({"message": "Invalid credentials"}), 401

@app.route('/events')
def get_events():
    return jsonify([{"title": e.title, "date": e.date} for e in Event.query.all()])

@app.route('/profile')
def get_profile():
    user = User.query.first()
    return jsonify({"email": user.email, "name": "Sawaed UAE"})

if __name__ == '__main__':
    app.run(debug=True)