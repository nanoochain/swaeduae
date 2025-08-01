import React, { useRef } from "react";
export default function MultiFileUpload({ onFiles }) {
  const ref = useRef();
  return (
    <div>
      <input type="file" ref={ref} multiple className="border rounded p-2" onChange={e => onFiles(Array.from(e.target.files))} />
    </div>
  );
}
