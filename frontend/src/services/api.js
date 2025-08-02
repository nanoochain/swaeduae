const BASE_URL = import.meta.env.VITE_API_URL || "https://swaeduae.ae/api";

async function request(endpoint, method = "GET", data = null, token = null) {
  const headers = {
    "Content-Type": "application/json",
  };
  if (token) {
    headers["Authorization"] = `Bearer ${token}`;
  }

  const config = {
    method,
    headers,
  };

  if (data) {
    config.body = JSON.stringify(data);
  }

  const res = await fetch(`${BASE_URL}${endpoint}`, config);
  if (!res.ok) {
    const error = await res.text();
    throw new Error(error);
  }
  return await res.json();
}

// Auth
export const login = (data) => request("/login", "POST", data);
export const signup = (data) => request("/signup", "POST", data);
export const getProfile = (token) => request("/profile", "GET", null, token);

// Events
export const getEvents = (token) => request("/events", "GET", null, token);

// Certificates
export const getCertificates = (token) => request("/certificates", "GET", null, token);
export const verifyCertificate = (id) => request(`/verify/${id}`, "GET");

// Admin
export const getAdminStats = (token) => request("/admin/stats", "GET", null, token);
export const getUsers = (token) => request("/admin/users", "GET", null, token);
export const getKYCSubmissions = (token) => request("/admin/kyc_submissions", "GET", null, token);
export const updateKYCSubmission = (id, status, token) =>
  request(`/admin/kyc_submissions/${id}`, "POST", { status }, token);
export const getVolunteerApprovals = (token) => request("/admin/volunteer_approvals", "GET", null, token);
export const updateVolunteerApproval = (id, approved, token) =>
  request(`/admin/volunteer_approvals/${id}`, "POST", { approved }, token);
export const listCertificates = (token) => request("/admin/certificates", "GET", null, token);
export const createCertificate = (data, token) => request("/admin/certificates", "POST", data, token);
export const getLogs = (token) => request("/admin/logs", "GET", null, token);

// KYC
export const uploadKYC = async (file, token) => {
  const formData = new FormData();
  formData.append("document", file);
  const res = await fetch(`${BASE_URL}/kyc/upload`, {
    method: "POST",
    headers: {
      Authorization: `Bearer ${token}`,
    },
    body: formData,
  });
  if (!res.ok) throw new Error("Failed to upload document");
  return await res.json();
};

// Payment
export const createPayment = (data, token) =>
  request("/payment", "POST", data, token);

// OTP
export const verifyOTP = (data) =>
  request("/verify-otp", "POST", data);
