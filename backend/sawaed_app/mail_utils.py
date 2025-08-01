from .extensions import mail
from flask_mail import Message

def send_certificate_email(to_email: str, subject: str, body: str, attachments=None) -> None:
    if mail is None:
        return
    msg = Message(subject, recipients=[to_email], body=body)
    if attachments:
        for attachment in attachments:
            msg.attach(attachment.filename, attachment.content_type, attachment.data)
    mail.send(msg)
