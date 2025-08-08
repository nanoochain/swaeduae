
use App\Http\Controllers\NotificationController;

Route::middleware('auth')->get('/notifications/fetch', [NotificationController::class, 'fetch'])->name('notifications.fetch');


use App\Http\Controllers\LanguageController;

Route::get('/lang/{locale}', [LanguageController::class, 'switch'])->name('lang.switch');

