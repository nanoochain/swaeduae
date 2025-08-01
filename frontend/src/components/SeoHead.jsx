import React from "react";
export default function SeoHead({ title, desc }) {
  React.useEffect(() => {
    document.title = title || "Sawaed UAE Volunteer Society";
    const m = document.querySelector("meta[name='description']");
    if (m) m.setAttribute("content", desc || "Sawaed Emirates Volunteer platform for events, volunteering, and certificates.");
  }, [title, desc]);
  return (
    <>
      <meta property="og:title" content={title || "Sawaed UAE Volunteer Society"} />
      <meta property="og:description" content={desc || "Volunteer events and certificates platform for UAE."} />
      <meta property="og:image" content="/vite.svg" />
      <meta property="og:url" content={window.location.href} />
      {/* Google Analytics: */}
      <script async src="https://www.googletagmanager.com/gtag/js?id=UA-XXXXXXXXX-X"></script>
      <script>
        {`
          window.dataLayer = window.dataLayer || [];
          function gtag(){dataLayer.push(arguments);}
          gtag('js', new Date());
          gtag('config', 'UA-XXXXXXXXX-X');
        `}
      </script>
    </>
  );
}
