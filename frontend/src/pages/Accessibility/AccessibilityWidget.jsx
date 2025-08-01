import React, { useState } from 'react';
export default function AccessibilityWidget() {
  const [fontSize, setFontSize] = useState(16);
  const [contrast, setContrast] = useState(false);

  return (
    <div className="fixed bottom-4 right-4 p-2 bg-white border rounded shadow-md">
      <button onClick={() => setFontSize(fontSize + 2)}>A+</button>
      <button onClick={() => setFontSize(fontSize - 2)}>A-</button>
      <button onClick={() => setContrast(!contrast)}>Contrast</button>
      <style jsx="true">{\`
        body { font-size: \${fontSize}px; }
        \${contrast ? 'body { filter: invert(1); background: black; }' : ''}
      \`}</style>
    </div>
  );
}
