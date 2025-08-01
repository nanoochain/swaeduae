import React, { useState } from 'react';
import axios from 'axios';

export default function KYCUpload() {
  const [file, setFile] = useState(null);
  const [message, setMessage] = useState('');

  const onFileChange = (e) => {
    setFile(e.target.files[0]);
  };

  const onSubmit = async (e) => {
    e.preventDefault();
    if (!file) {
      setMessage('Please select a file.');
      return;
    }
    const formData = new FormData();
    formData.append('document', file);

    try {
      const token = localStorage.getItem('token'); // Adjust token retrieval as per your auth
      const res = await axios.post('/kyc/upload', formData, {
        headers: {
          'Content-Type': 'multipart/form-data',
          Authorization: `Bearer ${token}`,
        },
      });
      setMessage('Upload successful!');
    } catch (err) {
      setMessage('Upload failed.');
    }
  };

  return (
    <div>
      <h2>KYC Document Upload</h2>
      <form onSubmit={onSubmit}>
        <input type="file" onChange={onFileChange} accept=".pdf,.jpg,.jpeg,.png" />
        <button type="submit">Upload</button>
      </form>
      <p>{message}</p>
    </div>
  );
}
