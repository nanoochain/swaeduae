#!/bin/bash

set -e

echo "Updating routes/web.php..."
cat << 'EOR' > routes/web.php
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AdminEventController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\VolunteerController;
use App\Http\Controllers\VolunteerProfileController;
use App\Http\Controllers\KycController;

// === PUBLIC PAGES ===
Route::view('/', 'welcome')->name('public.home');
Route::view('/about', 'about')->name('public.about');
Route::view('/contact', 'contact')->name('public.contact');
Route::view('/faq', 'faq')->name('public.faq');
Route::view('/team', 'team')->name('public.team');
Route::view('/partners', 'partners')->name('public.partners');
Route::view('/home', 'welcome')->name('home');
Route::view('/kyc', 'kyc')->name('kyc');
Route::view('/maintenance', 'maintenance')->name('maintenance');

// === AUTH ROUTES ===
Route::view('/login', 'auth.login')->name('login');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::view('/register', 'auth.register')->name('register');
Route::view('/forgot-password', 'auth.forgot-password')->name('password.request');

// === AUTHENTICATED USER PAGES ===
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::get('/certificates', [CertificateController::class, 'index'])->name('certificates.index');
    Route::get('/certificates/{id}', [CertificateController::class, 'show'])->name('certificates.show');
    Route::get('/events', [EventController::class, 'index'])->name('events.index');
    Route::get('/events/{id}', [EventController::class, 'show'])->name('events.show');

    // Volunteer specific routes
    Route::get('/volunteer/dashboard', [VolunteerController::class, 'dashboard'])->name('volunteer.dashboard');
    Route::get('/volunteer/hours', [VolunteerController::class, 'hours'])->name('volunteer.hours');
    Route::get('/volunteer/opportunities', [VolunteerController::class, 'opportunities'])->name('volunteer.opportunities');
    Route::get('/volunteer/profile', [VolunteerProfileController::class, 'show'])->name('volunteer.profile');
    Route::post('/volunteer/profile/update', [VolunteerProfileController::class, 'update'])->name('volunteer.profile.update');
});

// === ADMIN ROUTES ===
Route::prefix('admin')->middleware(['auth', 'is_admin'])->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/users', [AdminUserController::class, 'index'])->name('admin.users');
    Route::get('/events', [AdminEventController::class, 'index'])->name('admin.events');

    Route::get('/certificates', [CertificateController::class, 'adminIndex'])->name('admin.certificates.index');
    Route::get('/certificates/create', [CertificateController::class, 'create'])->name('admin.certificates.create');
    Route::get('/certificates/{id}', [CertificateController::class, 'adminShow'])->name('admin.certificates.show');

    Route::get('/kyc', [KycController::class, 'adminIndex'])->name('admin.kyc.index');
    Route::post('/kyc/{id}/approve', [KycController::class, 'approve'])->name('admin.kyc.approve');
    Route::post('/kyc/{id}/reject', [KycController::class, 'reject'])->name('admin.kyc.reject');
});

// === FALLBACK (404) ===
Route::fallback(function () {
    return response()->view('404', [], 404);
});
EOR

echo "Clearing Laravel caches..."
php artisan route:clear
php artisan cache:clear
php artisan config:clear
php artisan view:clear

echo "Done updating routes and clearing cache."
