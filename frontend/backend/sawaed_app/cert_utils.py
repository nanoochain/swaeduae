from fpdf import FPDF
import qrcode
from io import BytesIO
import os

def generate_certificate_pdf(cert, user, save_path):
    qr_url = f"https://swaeduae.ae/verify/{cert.id}"
    qr_img = qrcode.make(qr_url)
    qr_bytes = BytesIO()
    qr_img.save(qr_bytes, format="PNG")
    qr_bytes.seek(0)
    qr_file = f"{save_path}/qr_{cert.id}.png"
    with open(qr_file, "wb") as f:
        f.write(qr_bytes.read())

    pdf_file = f"{save_path}/certificate_{cert.id}.pdf"
    pdf = FPDF()
    pdf.add_page()
    pdf.set_font("Arial", size=24)
    pdf.cell(200, 20, txt="Sawaed UAE Volunteer Certificate", ln=True, align='C')
    pdf.set_font("Arial", size=16)
    pdf.cell(200, 20, txt=f"Presented to: {user.username}", ln=True, align='C')
    pdf.cell(200, 10, txt=f"For event: {getattr(cert, 'event_name', 'Event')}", ln=True, align='C')
    pdf.image(qr_file, x=80, y=80, w=50, h=50)
    pdf.output(pdf_file)
    return pdf_file
