import React from "react";
export default function HelpCenter() {
  return (
    <div className="max-w-3xl mx-auto p-8">
      <h1 className="text-3xl font-bold mb-6 text-blue-800">Help Center / الأسئلة الشائعة</h1>
      <div className="mb-8">
        <h2 className="text-xl font-bold">How do I register as a volunteer?</h2>
        <p>Just click <a href="/signup" className="text-blue-700 underline">here</a> and fill your details. You’ll get a confirmation email.</p>
      </div>
      <div className="mb-8">
        <h2 className="text-xl font-bold">Where do I find my certificates?</h2>
        <p>After your event is approved, your certificate will appear in your dashboard. Download as PDF or share by WhatsApp.</p>
      </div>
      <div className="mb-8">
        <h2 className="text-xl font-bold">Can I join with UAE PASS?</h2>
        <p>Yes! You can register/login instantly with UAE PASS.</p>
      </div>
      <div>
        <h2 className="text-xl font-bold">How to contact support?</h2>
        <p>Email us: <a href="mailto:support@swaeduae.ae" className="text-blue-700 underline">support@swaeduae.ae</a></p>
      </div>
    </div>
  );
}
