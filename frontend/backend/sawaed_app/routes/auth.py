from flask import Blueprint

auth_bp = Blueprint('auth', __name__)

# Example route
@auth_bp.route('/auth/ping')
def ping():
    return {'status': 'auth OK'}
