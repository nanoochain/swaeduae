<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\VolunteerController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\EventController as AdminEventController;
use App\Http\Middleware\AdminMiddleware;

/*
|--------------------------------------------------------------------------
| Public
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
Route::get('/faq', [HomeController::class, 'faq'])->name('faq');
Route::get('/platform', [HomeController::class, 'platform'])->name('platform');

Route::get('/opportunities', fn () => redirect()->route('events.index'))->name('opportunities');

/*
|--------------------------------------------------------------------------
| Locale switch (ar/en)
|--------------------------------------------------------------------------
*/
Route::get('/lang/{locale}', [HomeController::class, 'setLocale'])
    ->whereIn('locale', ['ar','en'])
    ->name('lang.switch');

/*
|--------------------------------------------------------------------------
| Auth (Laravel UI)
|--------------------------------------------------------------------------
*/
Auth::routes();

/*
|--------------------------------------------------------------------------
| Events (public)
|--------------------------------------------------------------------------
*/
Route::get('/events', [EventController::class, 'index'])->name('events.index');
Route::get('/events/{event}', [EventController::class, 'show'])->name('events.show');

/*
|--------------------------------------------------------------------------
| Certificates (public verify)
|--------------------------------------------------------------------------
*/
Route::get('/verify/{code}', [CertificateController::class, 'verify'])->name('cert.verify');

/*
|--------------------------------------------------------------------------
| Volunteer (auth)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/volunteer/profile', [VolunteerController::class, 'profile'])->name('volunteer.profile');
    // Friendly alias so "Dashboard" links work:
    Route::get('/dashboard', fn () => redirect()->route('volunteer.profile'))->name('dashboard');
});

/*
|--------------------------------------------------------------------------
| Admin (auth + admin)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', AdminMiddleware::class])
    ->prefix('admin')->as('admin.')->group(function () {
        // Optional landing page:
        Route::get('/', fn () => redirect()->route('admin.events.index'))->name('home');

        Route::resource('users', AdminUserController::class);
        Route::get('users/toggle/{id}', [AdminUserController::class, 'toggle'])->name('users.toggle');

        Route::resource('events', AdminEventController::class);
    });

/*
|--------------------------------------------------------------------------
| (Optional) Fallback 404 to home (comment out if you want default 404)
|--------------------------------------------------------------------------
*/
// Route::fallback(fn () => redirect()->route('home'));

/*
|--------------------------------------------------------------------------
| Event registration (auth)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::post('/events/{event}/join', [\App\Http\Controllers\EventRegistrationController::class, 'join'])->name('events.join');
    Route::delete('/events/{event}/unjoin', [\App\Http\Controllers\EventRegistrationController::class, 'unjoin'])->name('events.unjoin');
});
