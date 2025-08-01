from flask import Blueprint, jsonify

api_docs_bp = Blueprint('api_docs', __name__)

@api_docs_bp.route("/api/docs")
def api_docs():
    # A minimal OpenAPI example. For full Swagger, serve a YAML/JSON file or use flask-swagger-ui
    return jsonify({
        "openapi": "3.0.0",
        "info": {"title": "Sawaed UAE API", "version": "1.0"},
        "paths": {
            "/api/leaderboard": {"get": {"summary": "Leaderboard", "responses": {"200": {}}}},
            "/api/events": {"get": {"summary": "Event list", "responses": {"200": {}}}},
            "/api/feedback": {"post": {"summary": "Submit feedback", "responses": {"201": {}}}},
            "/api/pay": {"post": {"summary": "Initiate payment", "responses": {"200": {}}}},
        }
    })
