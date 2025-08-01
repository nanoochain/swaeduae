import React, { useState, useEffect, useRef } from "react";
import HeroCarousel from "@/components/HeroCarousel";
import SeoHead from "@/components/SeoHead";
import FeaturedCarousel from "@/components/FeaturedCarousel";
import DarkModeToggle from "@/components/DarkModeToggle";

const testimonials = [
  {
    name: "Fatima A.",
    text: "Volunteering through SawaedUAE changed my life! The events are so well organized and rewarding.",
    photo: "/images/testimonial1.jpg",
  },
  {
    name: "Khalid S.",
    text: "The certificate and leaderboard features motivate me to keep giving back. I love the recognition!",
    photo: "/images/testimonial2.jpg",
  },
  {
    name: "Mariam R.",
    text: "Best volunteer experience ever. The UAE PASS and WhatsApp integration made everything so easy.",
    photo: "/images/testimonial3.jpg",
  },
];

export default function Home() {
  const [testimonialIdx, setTestimonialIdx] = useState(0);
  const testimonialTimeout = useRef(null);

  useEffect(() => {
    testimonialTimeout.current = setTimeout(() => {
      setTestimonialIdx((i) => (i + 1) % testimonials.length);
    }, 7000);
    return () => clearTimeout(testimonialTimeout.current);
  }, [testimonialIdx]);

  return (
    <div className="bg-gray-50 min-h-screen dark:bg-gray-900">
      <SeoHead title="SawaedUAE – Volunteer Platform" desc="Empower, join, and celebrate volunteer work in the UAE." />
      <DarkModeToggle />
      <HeroCarousel />

      <div className="container mx-auto max-w-5xl px-6 py-10">
        <FeaturedCarousel />
        <h1 className="text-4xl md:text-5xl font-extrabold mb-6 text-blue-900 dark:text-white text-center">
          Welcome to Sawaed Emirates Volunteer Society
        </h1>
        <p className="text-lg text-gray-600 dark:text-gray-200 text-center mb-8">
          The all-in-one platform for volunteering, events, and national certificates.<br />
          Sign up with <span className="font-semibold">UAE PASS</span>, Google, or Apple.
        </p>
        <div className="flex justify-center mb-10">
          <a href="/signup" className="bg-blue-800 text-white px-8 py-3 rounded-2xl font-bold text-lg shadow hover:bg-blue-900 transition">
            Join Now
          </a>
        </div>

        <section className="my-16">
          <h2 className="text-2xl font-bold mb-6 text-blue-800 dark:text-blue-200 text-center">What Volunteers Say</h2>
          <div className="flex flex-col items-center">
            <div className="relative bg-white dark:bg-gray-800 rounded-xl shadow-xl p-8 max-w-xl text-center">
              <img
                src={testimonials[testimonialIdx].photo}
                alt={testimonials[testimonialIdx].name}
                className="w-16 h-16 rounded-full mx-auto mb-3 border-2 border-blue-700"
              />
              <p className="text-lg italic mb-3">"{testimonials[testimonialIdx].text}"</p>
              <span className="font-bold text-blue-900 dark:text-blue-200">{testimonials[testimonialIdx].name}</span>
              <div className="flex justify-center mt-4 gap-2">
                {testimonials.map((_, i) => (
                  <button
                    key={i}
                    className={`w-3 h-3 rounded-full ${i === testimonialIdx ? "bg-blue-800" : "bg-gray-300"}`}
                    onClick={() => setTestimonialIdx(i)}
                  />
                ))}
              </div>
            </div>
          </div>
        </section>
      </div>
    </div>
  );
}
