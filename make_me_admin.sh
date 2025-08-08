#!/bin/bash
php artisan tinker --execute="\$u = \App\Models\User::where('email', 'admin@swaeduae.ae')->first(); if(\$u){\$u->is_admin = 1; \$u->save(); echo 'User is now admin: ' . \$u->email . PHP_EOL;} else {echo 'No user found'.PHP_EOL;}"
