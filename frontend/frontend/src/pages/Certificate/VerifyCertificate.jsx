import React, { useState } from 'react';

const VerifyCertificate = () => {
  const [certId, setCertId] = useState('');
  const [result, setResult] = useState(null);

  const handleVerify = async () => {
    const res = await fetch(`https://swaeduae.ae/api/verify/${certId}`);
    const data = await res.json();
    setResult(data);
  };

  return (
    <div className="p-4">
      <h2 className="text-xl font-bold mb-4">Verify Certificate</h2>
      <input
        className="border p-2 mr-2"
        placeholder="Certificate ID"
        value={certId}
        onChange={(e) => setCertId(e.target.value)}
      />
      <button onClick={handleVerify} className="bg-green-600 text-white px-4 py-2">Verify</button>

      {result && (
        <div className="mt-4 bg-gray-100 p-2 rounded">
          <pre>{JSON.stringify(result, null, 2)}</pre>
        </div>
      )}
    </div>
  );
};

export default VerifyCertificate;
