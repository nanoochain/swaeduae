import React, { useEffect, useState } from 'react';
import axios from 'axios';

export default function VolunteerProfile() {
  const [profile, setProfile] = useState(null);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    axios.get('/api/volunteer/profile')
      .then(res => {
        setProfile(res.data);
        setLoading(false);
      })
      .catch(() => setLoading(false));
  }, []);

  if (loading) return <div>Loading profile...</div>;
  if (!profile) return <div>Error loading profile.</div>;

  return (
    <div className="p-6 max-w-4xl mx-auto">
      <h2 className="text-3xl font-bold mb-4" style={{ color: '#50C878' }}>My Profile</h2>
      <p><strong>Name:</strong> {profile.name}</p>
      <p><strong>Email:</strong> {profile.email}</p>

      <h3 className="text-2xl mt-6 mb-2">Volunteer History</h3>
      {profile.events.length === 0 ? (
        <p>No events attended yet.</p>
      ) : (
        <ul className="list-disc list-inside">
          {profile.events.map(ev => (
            <li key={ev.id}>
              {ev.name} — {ev.hours} hours on {new Date(ev.date).toLocaleDateString()}
            </li>
          ))}
        </ul>
      )}

      <h3 className="text-2xl mt-6 mb-2">Badges Earned</h3>
      <ul className="list-disc list-inside">
        {profile.badges.map(badge => (
          <li key={badge.id}>{badge.badge_name} (awarded {new Date(badge.awarded_at).toLocaleDateString()})</li>
        ))}
      </ul>

      <h3 className="text-2xl mt-6 mb-2">Certificates</h3>
      <ul className="list-disc list-inside">
        {profile.certificates.map(cert => (
          <li key={cert.id}><a href={cert.cert_url} target="_blank" rel="noopener noreferrer">{cert.event_name} Certificate</a></li>
        ))}
      </ul>
    </div>
  );
}
