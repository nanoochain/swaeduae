<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VolunteerOpportunityController;

// Home page route
Route::get('/', [HomeController::class, 'index'])->name('home');

// Authentication Routes
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [RegisterController::class, 'register']);

// Event Routes
Route::get('/events', [EventController::class, 'index'])->name('events.index');
Route::get('/events/{id}', [EventController::class, 'show'])->name('events.show');

// News Routes
Route::get('/news', [NewsController::class, 'index'])->name('news.index');
Route::get('/news/{id}', [NewsController::class, 'show'])->name('news.show');

// Certificates
Route::get('/certificates', [CertificateController::class, 'index'])->name('certificates.index');
Route::get('/certificates/{id}', [CertificateController::class, 'show'])->name('certificates.show');

// Profile
Route::get('/profile', [ProfileController::class, 'show'])->middleware('auth')->name('profile.show');

// Volunteer Opportunities
Route::get('/volunteer-opportunities', [VolunteerOpportunityController::class, 'index'])->name('volunteer.opportunities');
Route::get('/volunteer-opportunities/{id}', [VolunteerOpportunityController::class, 'show'])->name('volunteer.opportunities.show');

// Add more routes here as needed

