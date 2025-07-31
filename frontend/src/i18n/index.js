import i18n from 'i18next';
import { initReactI18next } from 'react-i18next';

const resources = {
  en: {
    translation: {
      dashboard: 'Dashboard',
      profile: 'Profile',
      certificates: 'Certificates',
      admin: 'Admin Panel',
      logout: 'Logout',
      language: 'Language',
    },
  },
  ar: {
    translation: {
      dashboard: 'لوحة التحكم',
      profile: 'الملف الشخصي',
      certificates: 'الشهادات',
      admin: 'لوحة المشرف',
      logout: 'تسجيل الخروج',
      language: 'اللغة',
    },
  },
};

i18n.use(initReactI18next).init({
  resources,
  lng: 'en',
  fallbackLng: 'en',
  interpolation: { escapeValue: false },
});

export default i18n;
