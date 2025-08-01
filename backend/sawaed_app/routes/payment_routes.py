from flask import Blueprint, request, jsonify
import os
import stripe

payment_bp = Blueprint('payment', __name__)
stripe.api_key = os.environ.get("STRIPE_SECRET_KEY")

@payment_bp.route("/api/pay", methods=["POST"])
def pay():
    data = request.json
    try:
        intent = stripe.PaymentIntent.create(
            amount=int(float(data["amount"]) * 100),  # amount in cents
            currency="aed",
            payment_method_types=["card"],
            description="Sawaed UAE Donation/Support"
        )
        return jsonify({"clientSecret": intent.client_secret}), 200
    except Exception as e:
        return jsonify({"error": str(e)}), 400
