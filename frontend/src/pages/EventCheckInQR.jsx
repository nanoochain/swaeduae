import React from "react";
import QRCode from "react-qr-code";

export default function EventCheckInQR({ eventId, userId }) {
  const qrData = JSON.stringify({ event: eventId, user: userId });
  return (
    <div className="flex flex-col items-center">
      <QRCode value={qrData} size={192} />
      <p className="mt-4 text-lg">Scan this QR code at the event entrance to check in!</p>
    </div>
  );
}
