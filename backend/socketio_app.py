from flask_socketio import SocketIO, emit

socketio = SocketIO(cors_allowed_origins="*")

def init_socketio(app):
    socketio.init_app(app)

    @socketio.on("connect")
    def handle_connect():
        emit("message", {"status": "connected"})

def broadcast_event(event, data):
    socketio.emit(event, data)
