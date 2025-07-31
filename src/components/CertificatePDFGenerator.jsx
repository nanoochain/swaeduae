// CertificatePDFGenerator.jsx
import React from 'react';
import { jsPDF } from 'jspdf';

const CertificatePDFGenerator = ({ cert }) => {
  const handleDownload = () => {
    const doc = new jsPDF();
    doc.setFontSize(18);
    doc.text("Volunteer Certificate", 20, 20);
    doc.setFontSize(12);
    doc.text(`This certifies that: ${cert.volunteer_name}`, 20, 40);
    doc.text(`Has participated in: ${cert.event_name}`, 20, 50);
    doc.text(`Issued on: ${cert.issue_date}`, 20, 60);
    doc.text(`Certificate ID: ${cert.id}`, 20, 70);
    doc.save(`${cert.volunteer_name}_certificate.pdf`);
  };

  return (
    <button
      onClick={handleDownload}
      className="mt-2 px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700"
    >
      Download PDF
    </button>
  );
};

export default CertificatePDFGenerator;
