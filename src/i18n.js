import i18n from 'i18next';
import { initReactI18next } from 'react-i18next';

i18n.use(initReactI18next).init({
  resources: {
    en: {
      translation: {
        "Sidebar": {
          "Title": "Sawaed UAE",
          "Dashboard": "Dashboard",
          "Profile": "Profile",
          "Certificates": "Certificates",
          "Volunteer": "Volunteer",
          "SwitchLang": "Switch Language",
          "Logout": "Logout"
        }
      }
    },
    ar: {
      translation: {
        "Sidebar": {
          "Title": "سواعد الإمارات",
          "Dashboard": "لوحة التحكم",
          "Profile": "الملف الشخصي",
          "Certificates": "الشهادات",
          "Volunteer": "المتطوع",
          "SwitchLang": "تغيير اللغة",
          "Logout": "تسجيل الخروج"
        }
      }
    }
  },
  lng: "en",
  fallbackLng: "en",
  interpolation: {
    escapeValue: false
  }
});

export default i18n;
