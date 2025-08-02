"""
Routes for handling payments using Stripe.

These endpoints facilitate creating a Stripe Checkout session for a
specified amount and currency.  Completed sessions can be handled via
webhooks or separate polling mechanisms.  Payments are recorded in the
database upon successful session creation.
"""

from __future__ import annotations

import os
from flask import Blueprint, request, jsonify, url_for
from sqlalchemy.exc import SQLAlchemyError

from ..models import db, Payment, User

payment_bp = Blueprint("payment_bp", __name__)


@payment_bp.route("/create-checkout-session", methods=["POST"])
def create_checkout_session():
    """Create a Stripe Checkout session for a payment.

    Expects a JSON body with ``user_id``, ``amount`` (in AED), and
    optionally ``currency`` (default 'aed').  Returns the URL to
    redirect the user to Stripe's hosted checkout page.
    """
    data = request.get_json() or {}
    user_id = data.get("user_id")
    amount = data.get("amount")
    currency = data.get("currency", "aed")

    # Basic validation
    if user_id is None or amount is None:
        return jsonify({"msg": "Missing user_id or amount"}), 400
    try:
        amount_int = int(float(amount) * 100)  # Convert to cents
    except (TypeError, ValueError):
        return jsonify({"msg": "Invalid amount"}), 400

    # Import Stripe lazily to avoid mandatory dependency
    try:
        import stripe  # type: ignore
    except ImportError:
        return jsonify({"error": "Stripe library not installed"}), 500
    secret = os.getenv("STRIPE_SECRET_KEY")
    if not secret:
        return jsonify({"error": "Stripe secret key not configured"}), 500
    stripe.api_key = secret

    try:
        session = stripe.checkout.Session.create(
            payment_method_types=["card"],
            mode="payment",
            line_items=[
                {
                    "price_data": {
                        "currency": currency,
                        "product_data": {"name": "SawaedUAE Donation"},
                        "unit_amount": amount_int,
                    },
                    "quantity": 1,
                }
            ],
            success_url=url_for("payment_bp.payment_success", _external=True) + "?session_id={CHECKOUT_SESSION_ID}",
            cancel_url=url_for("payment_bp.payment_cancel", _external=True),
        )
    except Exception as exc:
        return jsonify({"error": str(exc)}), 500

    # Record the payment in the DB with pending status
    payment = Payment(
        user_id=user_id,
        amount=float(amount),
        currency=currency,
        status="pending",
        stripe_session_id=session.id,
    )
    try:
        db.session.add(payment)
        db.session.commit()
    except SQLAlchemyError as exc:
        db.session.rollback()
        return jsonify({"error": f"DB error: {exc}"}), 500

    return jsonify({"checkout_url": session.url}), 200


@payment_bp.route("/success")
def payment_success():
    """Handle successful payments.

    Stripe will redirect here after a successful payment.  In a real
    application you would verify the session and update the payment
    record accordingly.  Here we simply return a confirmation message.
    """
    session_id = request.args.get("session_id")
    return jsonify({"msg": "Payment successful", "session_id": session_id}), 200


@payment_bp.route("/cancel")
def payment_cancel():
    """Handle cancelled payments."""
    return jsonify({"msg": "Payment cancelled"}), 200