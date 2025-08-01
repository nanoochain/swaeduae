import React, { useState, useEffect, useRef } from "react";
const slides = [
  { img: "/images/slide1.jpg", title: "Join our next event!", desc: "Sign up for Green UAE Day." },
  { img: "/images/slide2.jpg", title: "Volunteers Needed", desc: "Support local schools & hospitals." },
  { img: "/images/slide3.jpg", title: "Get Recognized", desc: "Earn badges & national certificates." },
];
export default function HeroCarousel() {
  const [idx, setIdx] = useState(0);
  const touchStart = useRef(null);
  useEffect(() => {
    const t = setInterval(() => setIdx(i => (i + 1) % slides.length), 7000);
    return () => clearInterval(t);
  }, []);
  const onTouchStart = e => (touchStart.current = e.touches[0].clientX);
  const onTouchEnd = e => {
    if (touchStart.current === null) return;
    const dx = e.changedTouches[0].clientX - touchStart.current;
    if (Math.abs(dx) > 40) setIdx(i => (dx > 0 ? (i - 1 + slides.length) % slides.length : (i + 1) % slides.length));
    touchStart.current = null;
  };
  return (
    <div className="relative h-60 w-full rounded-xl overflow-hidden shadow mb-8"
         onTouchStart={onTouchStart} onTouchEnd={onTouchEnd}>
      {slides.map((s, i) => (
        <div key={i}
             className={`absolute inset-0 flex flex-col justify-center items-center bg-black/30 transition-opacity duration-700 ${i === idx ? "opacity-100 z-10" : "opacity-0 z-0"}`}>
          <img src={s.img} alt={s.title} className="object-cover w-full h-full absolute z-0" />
          <div className="relative z-10 bg-white/80 p-6 rounded-xl text-center">
            <h2 className="font-bold text-2xl mb-2">{s.title}</h2>
            <p className="mb-3">{s.desc}</p>
            <a href="/signup" className="bg-blue-700 text-white px-5 py-2 rounded shadow-lg text-lg">Join Now</a>
          </div>
        </div>
      ))}
      <div className="absolute bottom-2 left-0 right-0 flex justify-center gap-2">
        {slides.map((_, i) => (
          <button key={i} className={`w-3 h-3 rounded-full ${i === idx ? "bg-blue-800" : "bg-gray-300"}`}
            onClick={() => setIdx(i)} />
        ))}
      </div>
    </div>
  );
}
