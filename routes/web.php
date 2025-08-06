<?php

use Illuminate\Support\Facades\Route;
use App\Models\Event;
use App\Models\News;

Route::get('/', function () {
    $events = Event::latest()->take(3)->get();
    $news = News::latest()->take(3)->get();
    return view('welcome', compact('events', 'news'));
});

// --- Other routes below ---

// Example:
Route::get('/events', [App\Http\Controllers\EventController::class, 'index'])->name('events.index');
// ... other routes ...
