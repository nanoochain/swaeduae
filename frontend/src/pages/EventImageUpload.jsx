import React, { useState } from 'react';

export default function EventImageUpload({ eventId }) {
  const [file, setFile] = useState(null);

  const handleUpload = () => {
    // TODO: Implement file upload to backend
    alert('Uploading event image for event id ' + eventId);
  };

  return (
    <div>
      <h3>Upload Event Image/Poster</h3>
      <input type="file" onChange={e => setFile(e.target.files[0])} />
      <button disabled={!file} onClick={handleUpload}>Upload</button>
    </div>
  );
}
