import axios from "axios";
const API = "/"; // Change for prod if needed

// Public
export async function getPublicEvents() {
  const { data } = await axios.get(API + "events");
  return data.events || [];
}
export async function registerForEvent(eventId) {
  return axios.post(API + "events/register", { event_id: eventId });
}

// Volunteer
export async function getVolunteerStats() {
  const { data } = await axios.get(API + "dashboard/stats");
  return data;
}
export async function getProfile() {
  const { data } = await axios.get(API + "profile");
  return data;
}
export async function getMyCertificates() {
  const { data } = await axios.get(API + "certificates");
  return data.certificates || [];
}

// Admin
export async function getAdminStats() {
  const { data } = await axios.get(API + "admin/stats");
  return data;
}
export async function getUsers() {
  const { data } = await axios.get(API + "admin/users");
  return data.users || [];
}
export async function approveUser(id) {
  return axios.post(API + "admin/users/approve", { id });
}
export async function banUser(id) {
  return axios.post(API + "admin/users/ban", { id });
}
export async function getEvents() {
  const { data } = await axios.get(API + "admin/events");
  return data.events || [];
}
export async function approveEvent(id) {
  return axios.post(API + "admin/events/approve", { id });
}
export async function getKYCSubmissions() {
  const { data } = await axios.get(API + "admin/kyc");
  return data.kyc || [];
}
export async function approveKYCSubmission(id) {
  return axios.post(API + "admin/kyc/approve", { id });
}
export async function getCertificates() {
  const { data } = await axios.get(API + "admin/certificates");
  return data.certificates || [];
}
export async function sendCertificate(id) {
  return axios.post(API + "admin/certificates/send", { id });
}
export async function getAdminLogs() {
  const { data } = await axios.get(API + "admin/logs");
  return data.logs || [];
}
