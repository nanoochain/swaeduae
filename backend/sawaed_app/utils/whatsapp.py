import requests
def send_whatsapp_message(phone, message, cert_url=None):
    # Use Twilio, WhatsApp Cloud API, or another provider
    api_url = "https://graph.facebook.com/v19.0/your_whatsapp_phone_id/messages"
    token = "YOUR_WHATSAPP_ACCESS_TOKEN"
    payload = {
        "messaging_product": "whatsapp",
        "to": phone,
        "type": "text",
        "text": {"body": message + (f"\\nDownload: {cert_url}" if cert_url else "")}
    }
    headers = {"Authorization": f"Bearer {token}", "Content-Type": "application/json"}
    return requests.post(api_url, json=payload, headers=headers).json()
