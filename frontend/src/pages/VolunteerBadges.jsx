import React from "react";

const BADGES = [
  { label: "Newbie", icon: "🥉", minHours: 0 },
  { label: "Achiever", icon: "🥈", minHours: 20 },
  { label: "Pro", icon: "🥇", minHours: 100 },
  { label: "Legend", icon: "🏆", minHours: 250 },
];

export default function VolunteerBadges({ hours }) {
  const badge = BADGES.reverse().find(b => hours >= b.minHours) || BADGES[0];
  return (
    <div className="text-3xl my-4">
      {badge.icon} <span className="ml-2 text-lg">{badge.label}</span>
    </div>
  );
}
