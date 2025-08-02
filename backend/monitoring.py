import requests
import ssl
import socket
from datetime import datetime

def check_uptime(url="https://swaeduae.ae"):
    try:
        response = requests.get(url, timeout=5)
        return response.status_code == 200
    except:
        return False

def check_ssl_expiry(domain="swaeduae.ae"):
    context = ssl.create_default_context()
    with socket.create_connection((domain, 443)) as sock:
        with context.wrap_socket(sock, server_hostname=domain) as ssock:
            cert = ssock.getpeercert()
            exp_date = datetime.strptime(cert['notAfter'], "%b %d %H:%M:%S %Y %Z")
            return (exp_date - datetime.utcnow()).days
