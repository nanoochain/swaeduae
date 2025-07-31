import React, { useState } from 'react';
import { uploadKYC } from '../../services/api';

export default function KYCUpload() {
  const [file, setFile] = useState(null);
  const handleSubmit = async (e) => {
    e.preventDefault();
    const formData = new FormData();
    formData.append('document', file);
    await uploadKYC(formData);
    alert('KYC submitted');
  };
  return (
    <form onSubmit={handleSubmit} className="p-4">
      <h2 className="text-xl font-bold mb-2">Upload KYC Document</h2>
      <input type="file" onChange={e => setFile(e.target.files[0])} />
      <button type="submit" className="btn btn-primary ml-2">Submit</button>
    </form>
  );
}
