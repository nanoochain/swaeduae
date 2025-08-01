import React, { useState } from 'react';

export default function KycUpload() {
  const [file, setFile] = useState(null);
  const [message, setMessage] = useState('');

  const token = localStorage.getItem('token');

  const handleFileChange = (e) => {
    setFile(e.target.files[0]);
  };

  const handleSubmit = async (e) => {
    e.preventDefault();
    if (!file) {
      setMessage('Please select a file.');
      return;
    }
    const formData = new FormData();
    formData.append('file', file);

    const res = await fetch('/kyc/upload', {
      method: 'POST',
      headers: {
        'Authorization': 'Bearer ' + token
      },
      body: formData
    });

    if (res.ok) {
      setMessage('KYC document uploaded successfully!');
    } else {
      const err = await res.json();
      setMessage('Upload failed: ' + (err.error || 'Unknown error'));
    }
  };

  return (
    <div>
      <h2>Upload KYC Document</h2>
      <form onSubmit={handleSubmit}>
        <input type="file" onChange={handleFileChange} accept=".png,.jpg,.jpeg,.pdf" />
        <button type="submit">Upload</button>
      </form>
      {message && <p>{message}</p>}
    </div>
  );
}
