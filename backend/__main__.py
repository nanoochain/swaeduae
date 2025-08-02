"""
Convenience entry point for running the backend directly.

When executed with ``python -m backend`` this module will create the
application and launch a development WSGI server.  For production
deployments use Gunicorn as defined in the Dockerfile.
"""

from sawaed_app import create_app

app = create_app()

if __name__ == "__main__":
    print("🚀 Starting SawaedUAE Flask App on http://0.0.0.0:5000")
    app.run(debug=False, host="0.0.0.0", port=5000)