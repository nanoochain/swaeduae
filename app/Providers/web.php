<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VolunteerController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\DownloadController;
use App\Http\Controllers\PartnerController;
use App\Http\Controllers\Admin\AdminController;

Route::get('/', function () { return view('welcome'); })->name('home');
Route::get('/events', [EventController::class, 'index'])->name('events.index');
Route::get('/events/{id}', [EventController::class, 'show'])->name('events.show');
Route::get('/news', [NewsController::class, 'index'])->name('news.index');
Route::get('/news/{id}', [NewsController::class, 'show'])->name('news.show');
Route::get('/downloads', [DownloadController::class, 'index'])->name('downloads.index');
Route::get('/region/sharjah', [EventController::class, 'sharjah'])->name('region.sharjah');
Route::get('/partners', [PartnerController::class, 'index'])->name('partners.index');

Route::post('/lang/switch', function (\Illuminate\Http\Request $request) {
    $lang = $request->input('lang');
    if (in_array($lang, ['en', 'ar'])) {
        session(['locale' => $lang]);
        app()->setLocale($lang);
    }
    return back();
})->name('lang.switch');

Route::middleware('auth')->group(function () {
    Route::get('/volunteer/profile', [VolunteerController::class, 'profile'])->name('volunteer.profile');
    Route::post('/volunteer/events/{eventId}/register', [VolunteerController::class, 'registerEvent'])->name('volunteer.registerEvent');
    Route::post('/volunteer/kyc/upload', [VolunteerController::class, 'uploadKyc'])->name('volunteer.uploadKyc');
    Route::get('/volunteer/resume', [VolunteerController::class, 'resume'])->name('volunteer.resume');
    Route::get('/volunteer/certificate/{certId}', [VolunteerController::class, 'generateCertificate'])->name('volunteer.generateCertificate');
});

Route::prefix('admin')->middleware(['auth', 'can:isAdmin'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    // ... other admin routes ...
});

Auth::routes();
