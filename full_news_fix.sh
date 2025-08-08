#!/bin/bash

# Add news route to web.php (append to file)
echo "
Route::get('/news', function () {
    return view('news.index');
})->name('news.index');
" >> routes/web.php

# Create news/index.blade.php view
mkdir -p resources/views/news
cat > resources/views/news/index.blade.php << 'EOV'
@extends('layouts.app')

@section('content')
<h1>News</h1>
<p>This section is under construction.</p>
@endsection
EOV

# Clear caches
php artisan route:clear
php artisan cache:clear
php artisan config:clear

echo "News route and view added, caches cleared."
