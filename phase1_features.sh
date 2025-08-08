#!/bin/bash
set -e

# 1. Add Role & Permission middleware (app/Http/Middleware/RoleMiddleware.php)
mkdir -p app/Http/Middleware
cat > app/Http/Middleware/RoleMiddleware.php << 'EOR'
<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle($request, Closure $next, ...$roles)
    {
        if (!Auth::check()) {
            abort(403, 'Unauthorized');
        }

        $user = Auth::user();

        if (!in_array($user->role, $roles)) {
            abort(403, 'Unauthorized - insufficient role');
        }

        return $next($request);
    }
}
EOR

# 2. Register RoleMiddleware in Kernel.php
sed -i "/'admin' =>/a \ \ \ \ 'role' => \App\Http\Middleware\RoleMiddleware::class," app/Http/Kernel.php

# 3. Create AuditLog model and migration
php artisan make:model AuditLog -m

# 4. Migration file: database/migrations/*_create_audit_logs_table.php
MIGRATION_FILE=$(ls -t database/migrations/*_create_audit_logs_table.php | head -1)
cat > "$MIGRATION_FILE" << 'EOM'
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuditLogsTable extends Migration
{
    public function up()
    {
        Schema::create('audit_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('action');
            $table->text('description')->nullable();
            $table->ipAddress('ip_address')->nullable();
            $table->timestamps();

            $table->index('user_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('audit_logs');
    }
}
EOM

# 5. Create AuditLog model content (app/Models/AuditLog.php)
cat > app/Models/AuditLog.php << 'EOMODEL'
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuditLog extends Model
{
    protected $fillable = ['user_id', 'action', 'description', 'ip_address'];
}
EOMODEL

# 6. Create an AuditHelper class (app/Helpers/AuditHelper.php)
mkdir -p app/Helpers
cat > app/Helpers/AuditHelper.php << 'EOH'
<?php
namespace App\Helpers;

use App\Models\AuditLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class AuditHelper
{
    public static function log($action, $description = null)
    {
        AuditLog::create([
            'user_id' => Auth::id(),
            'action' => $action,
            'description' => $description,
            'ip_address' => Request::ip(),
        ]);
    }
}
EOH

# 7. Bulk approve/reject example routes (add to routes/web.php)
cat >> routes/web.php << 'EOROUTE'

// Bulk user & KYC management routes (example)
use App\Http\Controllers\Admin\BulkActionController;

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::post('/users/bulk-approve', [BulkActionController::class, 'bulkApproveUsers'])->name('users.bulkApprove');
    Route::post('/kyc/bulk-approve', [BulkActionController::class, 'bulkApproveKyc'])->name('kyc.bulkApprove');
});
EOROUTE

# 8. Create BulkActionController.php (app/Http/Controllers/Admin/BulkActionController.php)
mkdir -p app/Http/Controllers/Admin
cat > app/Http/Controllers/Admin/BulkActionController.php << 'EOCONTROLLER'
<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Kyc;
use App\Helpers\AuditHelper;
use Illuminate\Http\Request;

class BulkActionController extends Controller
{
    public function bulkApproveUsers(Request $request)
    {
        $ids = $request->input('ids', []);
        User::whereIn('id', $ids)->update(['approved' => true]);
        AuditHelper::log('Bulk approved users', 'User IDs: '.implode(',', $ids));
        return response()->json(['status' => 'success']);
    }

    public function bulkApproveKyc(Request $request)
    {
        $ids = $request->input('ids', []);
        Kyc::whereIn('id', $ids)->update(['status' => 'approved']);
        AuditHelper::log('Bulk approved KYC', 'KYC IDs: '.implode(',', $ids));
        return response()->json(['status' => 'success']);
    }
}
EOCONTROLLER

echo "PHASE 1 FEATURES INSTALLED. Run 'php artisan migrate' to create audit_logs table."
