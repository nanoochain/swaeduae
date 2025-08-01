import React, { useEffect, useState } from "react";
export default function DarkModeToggle() {
  const [dark, setDark] = useState(() => localStorage.getItem("theme") === "dark");
  useEffect(() => {
    document.documentElement.classList.toggle("dark", dark);
    localStorage.setItem("theme", dark ? "dark" : "light");
  }, [dark]);
  return (
    <button className="ml-2 px-3 py-2 rounded border" onClick={() => setDark(d => !d)}>
      {dark ? "🌙" : "☀️"}
    </button>
  );
}
