import pytest

from sawaed_app import create_app, db


@pytest.fixture
def client():
    """Configure a new app instance for each test.

    The application is configured to use an in‑memory SQLite database and to
    enable testing mode.  At the end of each test the database schema is
    dropped to leave a clean state for the next test.
    """
    app = create_app()
    app.config.update(
        TESTING=True,
        SQLALCHEMY_DATABASE_URI='sqlite:///:memory:',
        JWT_SECRET_KEY='test-secret',
    )
    with app.app_context():
        db.create_all()
        yield app.test_client()
        db.drop_all()


def test_signup_and_login(client):
    # Register a new user
    res = client.post(
        '/auth/signup',
        json={'email': 'user@example.com', 'username': 'testuser', 'password': 'password'},
    )
    assert res.status_code in (200, 201)

    # Log in with the new credentials
    res = client.post('/auth/login', json={'email': 'user@example.com', 'password': 'password'})
    assert res.status_code == 200
    data = res.get_json()
    # Ensure both access and refresh tokens are returned
    assert 'access_token' in data and 'refresh_token' in data