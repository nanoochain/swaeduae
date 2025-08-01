from flask_socketio import SocketIO, emit
from flask import Flask

socketio = SocketIO(cors_allowed_origins="*")

def init_socketio(app: Flask):
    socketio.init_app(app)

# Example emit function:
def emit_dashboard_update(stats):
    socketio.emit('dashboard_stats', stats, broadcast=True)
