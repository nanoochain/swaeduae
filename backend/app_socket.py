from sawaed_app import create_app
from sawaed_app.socketio_server import socketio

app = create_app()

if __name__ == "__main__":
    socketio.init_app(app)
    socketio.run(app, host="0.0.0.0", port=5000)
