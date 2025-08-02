"""
Helper functions for sending notifications via email and WhatsApp.

These functions encapsulate third‑party services.  They read
configuration from environment variables and raise informative errors
when misconfigured.  Unit tests can mock these functions to avoid
network calls.
"""

from __future__ import annotations

import os
from typing import Optional

from flask_mail import Message
from ..extensions import mail


def send_email(recipient: str, subject: str, body: str) -> None:
    """Send an email using Flask‑Mail.

    Parameters
    ----------
    recipient : str
        The destination email address.
    subject : str
        Subject line for the email.
    body : str
        Plain‑text body of the email.
    """
    if not mail:
        raise RuntimeError("Flask-Mail is not configured")
    msg = Message(subject=subject, recipients=[recipient], body=body)
    mail.send(msg)


def send_whatsapp_message(to: str, body: str) -> Optional[str]:
    """Send a WhatsApp message via Twilio.

    Requires the ``twilio`` package and the following environment variables:

    - ``TWILIO_ACCOUNT_SID``: Your Twilio account SID
    - ``TWILIO_AUTH_TOKEN``: Your Twilio auth token
    - ``TWILIO_WHATSAPP_FROM``: The WhatsApp enabled sending number (e.g. 'whatsapp:+14155238886')

    Returns
    -------
    Optional[str]
        The Twilio message SID if the message was queued, otherwise ``None``.
    """
    sid = os.getenv("TWILIO_ACCOUNT_SID")
    token = os.getenv("TWILIO_AUTH_TOKEN")
    from_num = os.getenv("TWILIO_WHATSAPP_FROM")
    if not (sid and token and from_num):
        raise RuntimeError("Twilio credentials are not configured")
    try:
        from twilio.rest import Client  # type: ignore
    except ImportError as exc:
        raise RuntimeError("Twilio library is not installed") from exc
    client = Client(sid, token)
    message = client.messages.create(
        from_=from_num,
        to=to,
        body=body
    )
    return getattr(message, "sid", None)