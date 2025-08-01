import React, { useEffect, useState } from "react";
import axios from "axios";
export default function ReportingDashboard() {
  const [data, setData] = useState([]);
  useEffect(() => {
    axios.get("/api/admin/reporting").then(res => setData(res.data));
  }, []);
  function downloadCSV() {
    const csv = [Object.keys(data[0] || {}).join(",")].concat(
      data.map(d => Object.values(d).join(","))
    ).join("\n");
    const url = URL.createObjectURL(new Blob([csv], {type:"text/csv"}));
    const a = document.createElement("a");
    a.href = url; a.download = "report.csv"; a.click();
    URL.revokeObjectURL(url);
  }
  return (
    <div className="p-8">
      <h1 className="text-2xl font-bold mb-6">Reports</h1>
      <button className="bg-green-700 text-white px-4 py-2 rounded mb-4" onClick={downloadCSV}>Export CSV</button>
      <table className="w-full bg-white rounded">
        <thead>
          <tr>{Object.keys(data[0] || {}).map(k => <th key={k}>{k}</th>)}</tr>
        </thead>
        <tbody>
          {data.map((r, i) => <tr key={i}>{Object.values(r).map((v, j) => <td key={j}>{v}</td>)}</tr>)}
        </tbody>
      </table>
    </div>
  );
}
