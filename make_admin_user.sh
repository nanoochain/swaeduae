#!/bin/bash
cd /opt/swaeduae/backend

# Ensure .env and Laravel are loaded
source ~/.bashrc

# Use Tinker to grant admin to first user
php artisan tinker --execute="\$u = \App\Models\User::first(); \$u->is_admin = 1; \$u->save(); echo '✅ Admin access granted to: ' . \$u->email . \"\n\";"
