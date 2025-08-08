#!/bin/bash
set -e

# 1. Create Notification model and migration
php artisan make:model Notification -m

# 2. Migration for notifications table (database/migrations/*_create_notifications_table.php)
MIGRATION_FILE=$(ls -t database/migrations/*_create_notifications_table.php | head -1)
cat > "$MIGRATION_FILE" << 'EOM'
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationsTable extends Migration
{
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('type');
            $table->string('title');
            $table->text('message');
            $table->boolean('read')->default(false);
            $table->timestamps();

            $table->index('user_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('notifications');
    }
}
EOM

# 3. Notification model content (app/Models/Notification.php)
cat > app/Models/Notification.php << 'EOMODEL'
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = ['user_id', 'type', 'title', 'message', 'read'];
}
EOMODEL

# 4. NotificationController for admin notifications management (app/Http/Controllers/Admin/NotificationController.php)
mkdir -p app/Http/Controllers/Admin
cat > app/Http/Controllers/Admin/NotificationController.php << 'EOCONTROLLER'
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Notification::latest()->paginate(20);
        return view('admin.notifications.index', compact('notifications'));
    }

    public function markAsRead($id)
    {
        $notification = Notification::findOrFail($id);
        $notification->update(['read' => true]);
        return redirect()->back();
    }
}
EOCONTROLLER

# 5. Add routes for notifications (routes/web.php)
cat >> routes/web.php << 'EOROUTES'

// Notifications routes
use App\Http\Controllers\Admin\NotificationController;

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');
});
EOROUTES

# 6. Create notifications index view (resources/views/admin/notifications/index.blade.php)
mkdir -p resources/views/admin/notifications
cat > resources/views/admin/notifications/index.blade.php << 'EOVIEW'
@extends('layouts.admin_theme')

@section('content')
<h1>Notifications</h1>

<table>
    <thead>
        <tr><th>Title</th><th>Message</th><th>Status</th><th>Actions</th></tr>
    </thead>
    <tbody>
        @foreach ($notifications as $notification)
        <tr @if(!$notification->read) style="font-weight:bold" @endif>
            <td>{{ $notification->title }}</td>
            <td>{{ $notification->message }}</td>
            <td>{{ $notification->read ? 'Read' : 'Unread' }}</td>
            <td>
                @if (!$notification->read)
                <form method="POST" action="{{ route('admin.notifications.markAsRead', $notification->id) }}">
                    @csrf
                    <button type="submit">Mark as Read</button>
                </form>
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

{{ $notifications->links() }}
@endsection
EOVIEW

# 7. Export Reports routes and controller skeleton (app/Http/Controllers/Admin/ExportController.php)
cat > app/Http/Controllers/Admin/ExportController.php << 'EOCONTROLLER'
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ExportController extends Controller
{
    public function exportUsersCsv()
    {
        $filename = 'users_' . date('Ymd_His') . '.csv';

        $users = User::all();

        $response = new StreamedResponse(function () use ($users) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['ID', 'Name', 'Email', 'Role']);

            foreach ($users as $user) {
                fputcsv($handle, [$user->id, $user->name, $user->email, $user->role]);
            }
            fclose($handle);
        });

        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', "attachment; filename=\"$filename\"");

        return $response;
    }
}
EOCONTROLLER

# 8. Add export route (routes/web.php)
cat >> routes/web.php << 'EOROUTES'

use App\Http\Controllers\Admin\ExportController;

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/export/users', [ExportController::class, 'exportUsersCsv'])->name('export.users.csv');
});
EOROUTES

# 9. API Management controller and routes skeleton

cat > app/Http/Controllers/Admin/ApiKeyController.php << 'EOCONTROLLER'
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class ApiKeyController extends Controller
{
    public function index()
    {
        // TODO: Fetch and show API keys
        return view('admin.api_keys.index');
    }

    public function regenerate()
    {
        // TODO: Regenerate API keys logic
        return redirect()->back()->with('success', 'API keys regenerated.');
    }
}
EOCONTROLLER

cat >> routes/web.php << 'EOROUTES'

use App\Http\Controllers\Admin\ApiKeyController;

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/api-keys', [ApiKeyController::class, 'index'])->name('api_keys.index');
    Route::post('/api-keys/regenerate', [ApiKeyController::class, 'regenerate'])->name('api_keys.regenerate');
});
EOROUTES

# 10. Create empty API keys view (resources/views/admin/api_keys/index.blade.php)
mkdir -p resources/views/admin/api_keys
cat > resources/views/admin/api_keys/index.blade.php << 'EOVIEW'
@extends('layouts.admin_theme')

@section('content')
<h1>API Keys Management</h1>
<p>Manage your API keys here. (Implementation pending)</p>
@endsection
EOVIEW

echo "PHASE 2 FEATURES INSTALLED. Run 'php artisan migrate' to create notifications table."
