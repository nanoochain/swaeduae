import React, { useEffect, useState } from "react";
const slides = [
  { title: "Emirates Giving Day", desc: "Over 3,000 volunteers joined our biggest day yet!", img: "/images/slide1.jpg" },
  { title: "School Outreach", desc: "Partnered with 12 schools for youth volunteer programs.", img: "/images/slide2.jpg" },
  { title: "Sustainability Event", desc: "Promoting green volunteering across UAE.", img: "/images/slide3.jpg" },
];
export default function FeaturedCarousel() {
  const [idx, setIdx] = useState(0);
  useEffect(() => {
    const t = setInterval(() => setIdx(i => (i + 1) % slides.length), 6000);
    return () => clearInterval(t);
  }, []);
  return (
    <div className="relative w-full h-64 overflow-hidden rounded-xl shadow-lg my-10 bg-gray-200">
      {slides.map((s, i) => (
        <div key={i} className={`absolute inset-0 flex flex-col items-center justify-center transition-opacity duration-700 ${i === idx ? "opacity-100" : "opacity-0"}`}>
          <img src={s.img} alt={s.title} className="w-full h-40 object-cover rounded-t-xl" />
          <div className="bg-white p-4 rounded-b-xl w-full text-center">
            <h3 className="font-bold text-xl">{s.title}</h3>
            <p>{s.desc}</p>
          </div>
        </div>
      ))}
      <div className="absolute bottom-2 left-0 right-0 flex justify-center gap-2">
        {slides.map((_, i) => (
          <button key={i} className={`w-3 h-3 rounded-full ${i === idx ? "bg-blue-800" : "bg-gray-300"}`} onClick={() => setIdx(i)} />
        ))}
      </div>
    </div>
  );
}
