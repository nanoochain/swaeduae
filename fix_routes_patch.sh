#!/bin/bash
set -euo pipefail

# helper: add a line to routes/web.php only if a pattern is missing
add_if_missing() {
  local pattern="$1"
  local line="$2"
  grep -qF "$pattern" routes/web.php || echo "$line" >> routes/web.php
}

# 1) Make sure public named routes exist
add_if_missing "->name('about')"   "Route::view('/about', 'about')->name('about');"
add_if_missing "->name('contact')" "Route::view('/contact', 'contact')->name('contact');"
add_if_missing "->name('faq')"     "Route::view('/faq', 'faq')->name('faq');"

# 2) Make sure auth.php is required if present
add_if_missing "require __DIR__.'/auth.php';" "if (file_exists(__DIR__.'/auth.php')) { require __DIR__.'/auth.php'; }"

# 3) Add the missing admin users toggle route (middleware inline so it’s safe even if not inside the group)
TOGGLE="Route::post('/admin/users/{user}/toggle', [\\App\\Http\\Controllers\\Admin\\UserController::class, 'toggle'])->name('admin.users.toggle')->middleware(['web','auth','admin']);"
grep -q "admin.users.toggle" routes/web.php || echo "$TOGGLE" >> routes/web.php

# 4) Clear caches & show what we care about
php artisan route:clear || true
php artisan optimize || true

echo "== Named routes check =="
php artisan route:list --name=home --name=about --name=contact --name=faq --name=admin.users.toggle || true
