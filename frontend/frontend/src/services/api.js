import axios from "axios";
const API = "/api";

// --- Admin stats, delivery logs, bulk message ---
export async function getAdminStats() {
  const res = await axios.get(`${API}/admin/stats`);
  return res.data;
}
export async function getDeliveryLogs() {
  const res = await axios.get(`${API}/admin/delivery_logs`);
  return res.data;
}
export async function exportDeliveryLogs() {
  window.location.href = `${API}/admin/delivery_logs/export`;
}
export async function sendBulkMessage(data) {
  return axios.post(`${API}/admin/bulk_message`, data);
}

// --- User Management ---
export async function getUsers() {
  const res = await axios.get(`${API}/admin/users`);
  return res.data;
}
export async function approveUser(user_id) {
  return axios.post(`${API}/admin/approve_user`, { user_id });
}

// --- Events and Volunteers ---
export async function getEvents() {
  const res = await axios.get(`${API}/events`);
  return res.data;
}
export async function registerForEvent(event_id) {
  return axios.post(`${API}/events/register`, { event_id });
}
export async function getEventVolunteers(event_id) {
  const res = await axios.get(`${API}/admin/event_volunteers?event_id=` + event_id);
  return res.data;
}
export async function approveVolunteerForEvent(event_id, user_id) {
  return axios.post(`${API}/admin/approve_volunteer`, { event_id, user_id });
}

// --- KYC Admin ---
export async function getKYCSubmissions() {
  const res = await axios.get(`${API}/admin/kyc_submissions`);
  return res.data;
}
export async function approveKYCSubmission(kyc_id) {
  return axios.post(`${API}/admin/approve_kyc`, { kyc_id });
}

// --- Certificates ---
export async function getVolunteerCertificates() {
  const res = await axios.get(`${API}/certificates`);
  return res.data;
}
export async function verifyCertificate(cert_id) {
  const res = await axios.get(`${API}/certificates/verify/${cert_id}`);
  return res.data;
}
export async function approveCertificate(cert_id) {
  return axios.post("/api/certificates/approve", { cert_id });
}
export async function sendCertificate(cert_id, via) {
  return axios.post("/api/certificates/send", { cert_id, via });
}
export async function getCertificatePDF(cert_id) {
  return "/api/certificates/" + cert_id + "/pdf";
}
export async function verifyCertificatePublic(cert_id) {
  const res = await axios.get("/api/verify/" + cert_id);
  return res.data;
}
