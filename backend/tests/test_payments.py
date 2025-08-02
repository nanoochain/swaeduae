"""
Tests for the Stripe payment endpoint.

We mock out the Stripe client so that no real API calls are made.  The
endpoint should validate inputs, attempt to create a session, record
the payment in the database and return a checkout URL.
"""

import types
import pytest

from flask import Flask

from ..sawaed_app import create_app, db


@pytest.fixture
def app() -> Flask:
    app = create_app()
    app.config.update(
        SQLALCHEMY_DATABASE_URI='sqlite://',
        TESTING=True,
        STRIPE_SECRET_KEY='sk_test_dummy',
    )
    with app.app_context():
        db.create_all()
        yield app
        db.drop_all()


@pytest.fixture
def client(app: Flask):
    return app.test_client()


def test_create_checkout_session(monkeypatch, client):
    # Mock the Stripe checkout session creation
    class FakeSession:
        def __init__(self):
            self.id = 'cs_test_123'
            self.url = 'https://checkout.stripe.com/pay/cs_test_123'

    def fake_create(**kwargs):
        return FakeSession()

    # monkeypatch the stripe module imported inside the endpoint
    fake_stripe = types.SimpleNamespace(checkout=types.SimpleNamespace(Session=types.SimpleNamespace(create=fake_create)))
    monkeypatch.setitem(__import__('sys').modules, 'stripe', fake_stripe)

    # Perform the request
    resp = client.post('/api/payments/create-checkout-session', json={
        'user_id': 1,
        'amount': 50.0,
        'currency': 'aed'
    })
    assert resp.status_code == 200
    data = resp.get_json()
    assert data['checkout_url'].startswith('https://')