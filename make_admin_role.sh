#!/bin/bash
php artisan tinker --execute="\$u = \App\Models\User::where('email', 'admin@swaeduae.ae')->first(); if(\$u){\$u->role = 'admin'; \$u->save(); echo 'User role set to admin: ' . \$u->email . PHP_EOL;} else {echo 'No user found'.PHP_EOL;}"
