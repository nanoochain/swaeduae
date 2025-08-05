<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AdminEventController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\CertificateController;
// === PUBLIC PAGES ===
Route::view('/', 'welcome')->name('public.home');
Route::view('/about', 'about')->name('about');
Route::view('/contact', 'contact')->name('contact');
Route::view('/faq', 'faq')->name('faq');
Route::view('/team', 'team')->name('team');
Route::view('/partners', 'partners')->name('partners');
// === AUTHENTICATED USER PAGES ===
Route::middleware(['auth'])->group(function() {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::get('/certificates', [CertificateController::class, 'index'])->name('certificates.index');
    Route::get('/events', [EventController::class, 'index'])->name('events.index');
});
// === ADMIN ROUTES ===
Route::prefix('admin')->middleware(['auth', 'is_admin'])->group(function() {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/users', [AdminUserController::class, 'index'])->name('admin.users');
    Route::get('/events', [AdminEventController::class, 'index'])->name('admin.events');
    // Add other admin routes here as needed
// === AUTH ROUTES ===
Route::view('/forgot-password', 'auth.forgot-password')->name('password.request');
// === FALLBACK (404) ===
Route::fallback(function() {
    return view('404');
// TEMP FIX: Volunteer Opportunities route for homepage link
