import React from 'react';
import { useLanguage } from '../context/LanguageContext';
import translations from '../i18n';

const LanguageToggle = () => {
  const { lang, toggleLanguage } = useLanguage();

  return (
    <button onClick={toggleLanguage}>
      {translations[lang].language}: {lang === 'en' ? translations[lang].arabic : translations[lang].english}
    </button>
  );
};

export default LanguageToggle;
