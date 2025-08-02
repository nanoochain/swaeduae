"""
Tests for the notification endpoints.

These tests mock out the underlying send functions to ensure that the
routes behave correctly without sending actual messages.
"""

import pytest
from flask import Flask

from ..sawaed_app import create_app, db


@pytest.fixture
def app() -> Flask:
    app = create_app()
    app.config.update(SQLALCHEMY_DATABASE_URI='sqlite://', TESTING=True)
    with app.app_context():
        db.create_all()
        yield app
        db.drop_all()


@pytest.fixture
def client(app: Flask):
    return app.test_client()


def test_send_email_route(monkeypatch, client):
    """Mock the email sending function and ensure the route calls it."""
    from ..sawaed_app.utils import notifications
    called = {}
    def fake_send_email(recipient, subject, body):
        called['recipient'] = recipient
        called['subject'] = subject
        called['body'] = body
    monkeypatch.setattr(notifications, 'send_email', fake_send_email)
    resp = client.post('/api/notify/email', json={'recipient': 'bob@example.com', 'subject': 'Test', 'body': 'Hello'})
    assert resp.status_code == 200
    assert called['recipient'] == 'bob@example.com'


def test_send_whatsapp_route(monkeypatch, client):
    """Mock the WhatsApp sending function and ensure the route calls it."""
    from ..sawaed_app.utils import notifications
    called = {}
    def fake_send_whatsapp_message(to, body):
        called['to'] = to
        called['body'] = body
        return 'fake-sid'
    monkeypatch.setattr(notifications, 'send_whatsapp_message', fake_send_whatsapp_message)
    resp = client.post('/api/notify/whatsapp', json={'to': 'whatsapp:+971555555555', 'body': 'Hi'})
    assert resp.status_code == 200
    assert called['to'] == 'whatsapp:+971555555555'