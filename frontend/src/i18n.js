import i18n from "i18next";
import { initReactI18next } from "react-i18next";

const resources = {
  en: {
    translation: {
      "Sign In to Sawaed UAE": "Sign In to Sawaed UAE",
      "Login with UAE PASS": "Login with UAE PASS",
      "Backup & Restore Database": "Backup & Restore Database",
      "Download Backup": "Download Backup",
      "Restore (Coming Soon)": "Restore (Coming Soon)",
      "System Logs (Last 100 lines)": "System Logs (Last 100 lines)",
      "Welcome": "Welcome",
      "Volunteer Events": "Volunteer Events",
      "Register": "Register",
      // ... add all other UI translations
    }
  },
  ar: {
    translation: {
      "Sign In to Sawaed UAE": "تسجيل الدخول إلى سواعد الإمارات",
      "Login with UAE PASS": "تسجيل الدخول عبر الهوية الرقمية",
      "Backup & Restore Database": "نسخ واستعادة قاعدة البيانات",
      "Download Backup": "تحميل النسخة الاحتياطية",
      "Restore (Coming Soon)": "الاستعادة (قريباً)",
      "System Logs (Last 100 lines)": "سجلات النظام (آخر 100 سطر)",
      "Welcome": "مرحباً",
      "Volunteer Events": "فعاليات التطوع",
      "Register": "تسجيل",
      // ... add all other UI translations
    }
  }
};

i18n
  .use(initReactI18next)
  .init({
    resources,
    lng: "en",
    fallbackLng: "en",
    interpolation: { escapeValue: false }
  });

export default i18n;
