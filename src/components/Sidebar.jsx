import React from 'react';
import { Link, useNavigate } from 'react-router-dom';
import { useTranslation } from 'react-i18next';
import { useAuth } from '../context/AuthContext';

const Sidebar = () => {
  const { logout, user } = useAuth();
  const { t, i18n } = useTranslation();
  const navigate = useNavigate();

  const handleLogout = () => {
    logout();
    navigate('/');
  };

  const switchLanguage = () => {
    const nextLang = i18n.language === 'en' ? 'ar' : 'en';
    i18n.changeLanguage(nextLang);
  };

  return (
    <div className="w-64 min-h-screen bg-gray-100 p-4 border-r">
      <h2 className="text-xl font-bold mb-4">{t('Sidebar.Title')}</h2>
      <ul className="space-y-2">
        <li><Link to="/dashboard">{t('Sidebar.Dashboard')}</Link></li>
        <li><Link to="/profile">{t('Sidebar.Profile')}</Link></li>
        <li><Link to="/certificates">{t('Sidebar.Certificates')}</Link></li>
        <li><Link to="/volunteer">{t('Sidebar.Volunteer')}</Link></li>
        {user?.role === 'admin' && <li><Link to="/admin">{t('Sidebar.Admin')}</Link></li>}
        <li><button onClick={switchLanguage} className="text-sm underline mt-2">{t('Sidebar.SwitchLang')}</button></li>
        <li><button onClick={handleLogout} className="text-red-500">{t('Sidebar.Logout')}</button></li>
      </ul>
    </div>
  );
};

export default Sidebar;
