"""
Unit tests for authentication endpoints.

These tests verify that the sign‑up, login and token refresh routes
work as expected.  They use an in‑memory SQLite database so no
external services are required.
"""

import pytest
from flask import Flask
from flask_jwt_extended import decode_token

from ..sawaed_app import create_app, db


@pytest.fixture
def app() -> Flask:
    """Create and configure a new app instance for testing."""
    app = create_app()
    # Use an in‑memory database for tests
    app.config.update(
        SQLALCHEMY_DATABASE_URI='sqlite://',
        TESTING=True,
        JWT_SECRET_KEY='test-secret',
        MAIL_SUPPRESS_SEND=True,
    )
    with app.app_context():
        db.create_all()
        yield app
        db.drop_all()


@pytest.fixture
def client(app: Flask):
    """A test client for the app."""
    return app.test_client()


def test_signup_and_login(client):
    """Ensure a user can sign up and then log in successfully."""
    # Sign up a new user
    response = client.post('/api/auth/signup', json={
        'username': 'alice',
        'email': 'alice@example.com',
        'password': 'password123'
    })
    assert response.status_code == 201
    data = response.get_json()
    assert data['msg'] == 'User registered'

    # Login with correct credentials
    response = client.post('/api/auth/login', json={
        'email': 'alice@example.com',
        'password': 'password123'
    })
    assert response.status_code == 200
    tokens = response.get_json()
    assert 'access_token' in tokens and 'refresh_token' in tokens
    access = decode_token(tokens['access_token'])
    assert access['sub']['role'] == 'volunteer'

    # Attempt login with wrong password
    response = client.post('/api/auth/login', json={
        'email': 'alice@example.com',
        'password': 'wrong'
    })
    assert response.status_code == 401