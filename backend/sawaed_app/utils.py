from flask import request, abort
from flask_jwt_extended import verify_jwt_in_request, get_jwt_claims

def role_required(*roles):
    def wrapper(fn):
        def decorator(*args, **kwargs):
            verify_jwt_in_request()
            claims = get_jwt_claims()
            if claims.get('role') not in roles:
                abort(403, description="You do not have access to this resource")
            return fn(*args, **kwargs)
        decorator.__name__ = fn.__name__
        return decorator
    return wrapper

def get_locale():
    lang = request.args.get('lang')
    if lang in ['en', 'ar']:
        return lang
    return 'en'
