from . import mail
from flask_mail import Message

def send_certificate_email(to_email, subject, body, attachments=None):
    msg = Message(subject, recipients=[to_email], body=body)
    if attachments:
        for attachment in attachments:
            msg.attach(attachment.filename, attachment.content_type, attachment.data)
    mail.send(msg)
