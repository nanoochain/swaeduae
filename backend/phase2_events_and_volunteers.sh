# --- Phase 2: Volunteer Event Registration & Admin Volunteer Management --- #
# This script creates/updates all necessary files for event listing, registration, and admin approval tools.

# --- FRONTEND FILES --- #

cd /opt/swaeduae/frontend/src/pages

# PublicEventList.jsx - volunteers see and register
cat << 'EOF' > PublicEventList.jsx
import React, { useEffect, useState } from "react";
import { getEvents, registerForEvent } from "@/services/api";

export default function PublicEventList() {
  const [events, setEvents] = useState([]);
  const [status, setStatus] = useState("");
  useEffect(() => {
    getEvents().then(setEvents);
  }, []);
  const handleRegister = async (eventId) => {
    await registerForEvent(eventId);
    setStatus("Registered!");
  };
  return (
    <div className="p-4">
      <h2 className="text-2xl font-bold mb-4">Volunteer Events</h2>
      {status && <div className="mb-2 text-green-600">{status}</div>}
      <div className="grid gap-4">
        {events.map(ev => (
          <div key={ev.id} className="border rounded p-4 flex flex-col md:flex-row justify-between items-center">
            <div>
              <h3 className="font-bold">{ev.title}</h3>
              <div className="text-sm text-gray-700">{ev.date}</div>
              <div>{ev.location}</div>
              <div className="text-xs">{ev.description}</div>
            </div>
            <button className="btn btn-primary mt-2 md:mt-0" onClick={() => handleRegister(ev.id)}>
              Register
            </button>
          </div>
        ))}
      </div>
    </div>
  );
}
EOF

# AdminEventVolunteers.jsx - admin sees all volunteers per event
cat << 'EOF' > AdminEventVolunteers.jsx
import React, { useEffect, useState } from "react";
import { getEventVolunteers, approveVolunteerForEvent } from "@/services/api";

export default function AdminEventVolunteers() {
  const [eventId, setEventId] = useState("");
  const [vols, setVols] = useState([]);
  const [status, setStatus] = useState("");

  const handleFetch = async () => {
    if (eventId) setVols(await getEventVolunteers(eventId));
  };

  const handleApprove = async (userId) => {
    await approveVolunteerForEvent(eventId, userId);
    setStatus("Approved!");
    setVols(await getEventVolunteers(eventId));
  };

  return (
    <div className="bg-white shadow rounded p-4 mt-4">
      <h2 className="font-bold mb-2">Approve Event Volunteers</h2>
      <input
        className="input mb-2"
        placeholder="Event ID"
        value={eventId}
        onChange={e => setEventId(e.target.value)}
      />
      <button className="btn btn-secondary mb-2" onClick={handleFetch}>Load Volunteers</button>
      {status && <div className="text-green-600">{status}</div>}
      <table className="table-auto text-sm w-full">
        <thead>
          <tr><th>User</th><th>Status</th><th>Approve</th></tr>
        </thead>
        <tbody>
          {vols.map(v => (
            <tr key={v.id}>
              <td>{v.user_email}</td>
              <td>{v.status}</td>
              <td>
                {v.status !== "approved" && (
                  <button className="btn btn-primary btn-xs" onClick={() => handleApprove(v.user_id)}>
                    Approve
                  </button>
                )}
              </td>
            </tr>
          ))}
        </tbody>
      </table>
    </div>
  );
}
EOF

# --- FRONTEND SERVICE FUNCTIONS --- #

cd /opt/swaeduae/frontend/src/services
cat << 'EOF' >> api.js

export async function getEvents() {
  const res = await axios.get("/api/events");
  return res.data;
}
export async function registerForEvent(event_id) {
  return axios.post("/api/events/register", { event_id });
}
export async function getEventVolunteers(event_id) {
  const res = await axios.get("/api/admin/event_volunteers?event_id=" + event_id);
  return res.data;
}
export async function approveVolunteerForEvent(event_id, user_id) {
  return axios.post("/api/admin/approve_volunteer", { event_id, user_id });
}
EOF

# --- BACKEND FILES --- #

cd /opt/swaeduae/backend/sawaed_app/routes
cat << 'EOF' > events.py
from flask import Blueprint, request, jsonify
from ..models import db, Event, User, Certificate
from flask_jwt_extended import jwt_required, get_jwt_identity

events_bp = Blueprint('events', __name__)

@events_bp.route("/events", methods=["GET"])
def get_events():
    events = Event.query.all()
    result = [
        {
            "id": ev.id,
            "title": ev.title,
            "date": ev.date.strftime("%Y-%m-%d"),
            "description": ev.description,
            "location": ev.location,
        }
        for ev in events
    ]
    return jsonify(result)

@events_bp.route("/events/register", methods=["POST"])
@jwt_required()
def register_event():
    user_id = get_jwt_identity()
    event_id = request.json.get("event_id")
    # Prevent duplicate registration
    from ..models import EventVolunteer
    existing = EventVolunteer.query.filter_by(user_id=user_id, event_id=event_id).first()
    if existing:
        return jsonify({"status": "already registered"})
    ev = EventVolunteer(user_id=user_id, event_id=event_id, status="pending")
    db.session.add(ev)
    db.session.commit()
    return jsonify({"status": "registered"})
EOF

cd /opt/swaeduae/backend/sawaed_app/routes
cat << 'EOF' > admin_event.py
from flask import Blueprint, request, jsonify
from ..models import db, EventVolunteer, User
from flask_jwt_extended import jwt_required

admin_event_bp = Blueprint('admin_event', __name__)

@admin_event_bp.route("/admin/event_volunteers", methods=["GET"])
@jwt_required()
def event_volunteers():
    event_id = request.args.get("event_id")
    vols = EventVolunteer.query.filter_by(event_id=event_id).all()
    data = []
    for v in vols:
        user = User.query.get(v.user_id)
        data.append({
            "id": v.id,
            "user_id": v.user_id,
            "user_email": user.email if user else "",
            "status": v.status,
        })
    return jsonify(data)

@admin_event_bp.route("/admin/approve_volunteer", methods=["POST"])
@jwt_required()
def approve_volunteer():
    event_id = request.json.get("event_id")
    user_id = request.json.get("user_id")
    vol = EventVolunteer.query.filter_by(event_id=event_id, user_id=user_id).first()
    if not vol:
        return jsonify({"error": "Not found"}), 404
    vol.status = "approved"
    db.session.commit()
    return jsonify({"status": "approved"})
EOF

# --- BACKEND MODEL ADDITION (EventVolunteer) --- #

cd /opt/swaeduae/backend/sawaed_app
cat << 'EOF' >> models.py

class EventVolunteer(db.Model):
    __tablename__ = "event_volunteer"
    id = db.Column(db.Integer, primary_key=True)
    event_id = db.Column(db.Integer, db.ForeignKey('event.id'))
    user_id = db.Column(db.Integer, db.ForeignKey('user.id'))
    status = db.Column(db.String(20), default="pending")
EOF

echo "✅ Phase 2 files created/updated. Don't forget:"
echo "cd /opt/swaeduae/backend && alembic revision --autogenerate -m 'Add EventVolunteer' && alembic upgrade head"
echo "cd /opt/swaeduae/frontend && npm install && npm run build && sudo cp -r dist/* /var/www/swaeduae.ae/html/ && sudo systemctl reload nginx"
