import React from "react";
export default function SocialLoginButtons() {
  return (
    <div className="flex gap-4 justify-center my-6">
      <a href="/auth/google/login">
        <img src="https://developers.google.com/identity/images/btn_google_signin_dark_normal_web.png" alt="Google Login" className="h-10" />
      </a>
      <a href="/auth/apple/login">
        <img src="/apple-login-btn.svg" alt="Apple Login" className="h-10" />
      </a>
    </div>
  );
}
