import React, { useState } from 'react';
import { uploadKYC } from '../services/api.js';

/*
 * Allows volunteers to upload identity documents for Know Your Customer
 * verification. The backend endpoint `/kyc/upload` accepts multipart
 * form data and saves the file on the server【648640763498140†L16-L39】. Only
 * PDF and image formats are accepted; unsupported types will return
 * a 400 response【648640763498140†L11-L31】. After a successful upload the user
 * receives a simple confirmation.
 */
export default function KYCUpload() {
  const [file, setFile] = useState(null);
  const [message, setMessage] = useState('');
  const handleSubmit = async (e) => {
    e.preventDefault();
    if (!file) return;
    const formData = new FormData();
    formData.append('document', file);
    try {
      await uploadKYC(formData);
      setMessage('Document uploaded successfully');
      setFile(null);
    } catch (err) {
      setMessage('Upload failed');
      console.error(err);
    }
  };
  return (
    <div>
      <h1>KYC Upload</h1>
      <form onSubmit={handleSubmit}>
        <input
          type="file"
          accept=".pdf,.jpg,.jpeg,.png"
          onChange={(e) => setFile(e.target.files[0])}
        />
        <button type="submit">Submit</button>
      </form>
      {message && <p>{message}</p>}
    </div>
  );
}