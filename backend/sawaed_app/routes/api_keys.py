from flask import Blueprint, request, jsonify
from ..models import db, APIKey, Webhook
import secrets, datetime

api_keys_bp = Blueprint('api_keys', __name__)

@api_keys_bp.route("/api/admin/api-keys", methods=["GET", "POST", "DELETE"])
def manage_keys():
    if request.method == "POST":
        key = secrets.token_hex(24)
        db.session.add(APIKey(key=key, created_at=datetime.datetime.utcnow()))
        db.session.commit()
        return jsonify({"api_key": key})
    elif request.method == "DELETE":
        key = request.args.get("key")
        APIKey.query.filter_by(key=key).delete()
        db.session.commit()
        return jsonify({"deleted": True})
    else:
        keys = APIKey.query.all()
        return jsonify([k.to_dict() for k in keys])

@api_keys_bp.route("/api/admin/webhooks", methods=["GET", "POST"])
def manage_webhooks():
    if request.method == "POST":
        url = request.json.get("url")
        db.session.add(Webhook(url=url, created_at=datetime.datetime.utcnow()))
        db.session.commit()
        return jsonify({"added": url})
    else:
        return jsonify([w.to_dict() for w in Webhook.query.all()])
