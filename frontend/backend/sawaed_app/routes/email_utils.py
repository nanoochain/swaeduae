import smtplib
from email.mime.text import MIMEText

def send_bulk_email(emails, subject, message):
    # Example - replace with real SMTP config or use a service (SendGrid, etc)
    smtp_server = "localhost"
    smtp_port = 25
    sender = "noreply@swaeduae.ae"
    for email in emails:
        msg = MIMEText(message)
        msg["Subject"] = subject
        msg["From"] = sender
        msg["To"] = email
        try:
            with smtplib.SMTP(smtp_server, smtp_port) as server:
                server.sendmail(sender, [email], msg.as_string())
        except Exception as e:
            print("Failed to send email to", email, e)
