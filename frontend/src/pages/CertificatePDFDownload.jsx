import React from "react";
import jsPDF from "jspdf";

export default function CertificatePDFDownload({ cert }) {
  const handleDownload = () => {
    const doc = new jsPDF();
    doc.text("Sawaed UAE Volunteer Certificate", 20, 20);
    doc.text(`Name: ${cert.name}`, 20, 40);
    doc.text(`Event: ${cert.event}`, 20, 60);
    doc.text(`Date: ${cert.date}`, 20, 80);
    doc.save("certificate.pdf");
  };
  return <button className="bg-green-700 text-white px-4 py-2 rounded" onClick={handleDownload}>Download as PDF</button>;
}
