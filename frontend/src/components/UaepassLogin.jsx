import React from 'react';

export default function UaepassLogin() {
  const uaepassLoginUrl = '/auth/uaepass/login'; // backend redirect

  return (
    <div>
      <a href={uaepassLoginUrl} className="btn btn-primary">
        Login with UAE PASS
      </a>
    </div>
  );
}
