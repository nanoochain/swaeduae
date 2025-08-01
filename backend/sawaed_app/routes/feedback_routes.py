from flask import Blueprint, request, jsonify
from ..models import db

feedback_bp = Blueprint('feedback', __name__)

class Feedback(db.Model):
    id = db.Column(db.Integer, primary_key=True)
    user = db.Column(db.String(128))
    rating = db.Column(db.Integer)
    comments = db.Column(db.Text)

@feedback_bp.route("/api/feedback", methods=["POST"])
def feedback():
    data = request.json
    fb = Feedback(user="Anonymous", rating=data.get("rating",5), comments=data.get("comments",""))
    db.session.add(fb)
    db.session.commit()
    return jsonify({"success":True}), 201

@feedback_bp.route("/api/leaderboard", methods=["GET"])
def leaderboard():
    # Example: Return top 10 volunteers (stubbed)
    return jsonify([
        {"id": 1, "username": "Ali", "hours": 120, "events": 18},
        {"id": 2, "username": "Fatima", "hours": 98, "events": 15},
        {"id": 3, "username": "Mohammed", "hours": 95, "events": 14},
        {"id": 4, "username": "Sara", "hours": 90, "events": 16},
        {"id": 5, "username": "Salem", "hours": 86, "events": 13},
    ])
