import React from "react";
export default function WCAGLandmarks({ children }) {
  return (
    <div>
      <header role="banner" className="sr-only">Site Banner</header>
      <nav role="navigation" aria-label="Main Menu" />
      <main role="main">{children}</main>
      <footer role="contentinfo" className="sr-only">Site Footer</footer>
    </div>
  );
}
