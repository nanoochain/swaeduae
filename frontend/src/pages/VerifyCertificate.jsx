import React, { useEffect, useState } from 'react';
import { useParams } from 'react-router-dom';
import axios from 'axios';

const VerifyCertificate = () => {
  const { cert_id } = useParams();
  const [status, setStatus] = useState(null);

  useEffect(() => {
    axios.get(`/verify/${cert_id}`)
      .then(res => setStatus(res.data.message))
      .catch(() => setStatus("❌ الشهادة غير موجودة أو غير صالحة"));
  }, [cert_id]);

  return (
    <div className="p-4">
      <h1 className="text-2xl font-bold mb-4">🔍 تحقق من الشهادة</h1>
      <p className="text-lg">{status}</p>
    </div>
  );
};

export default VerifyCertificate;
