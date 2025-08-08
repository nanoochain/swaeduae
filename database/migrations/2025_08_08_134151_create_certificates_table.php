<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades.Schema;

return new class extends Migration {
    public function up(): void {
        if (!Schema::hasTable('certificates')) {
            Schema::create('certificates', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained()->cascadeOnDelete();
                $table->foreignId('event_id')->nullable()->constrained()->nullOnDelete();
                $table->string('code')->unique();
                $table->timestamp('issued_at')->nullable();
                $table->string('status')->default('issued'); // issued/revoked
                $table->timestamps();
            });
        } else {
            Schema::table('certificates', function (Blueprint $table) {
                if (!Schema::hasColumn('certificates', 'user_id')) {
                    $table->foreignId('user_id')->after('id')->constrained()->cascadeOnDelete();
                }
                if (!Schema::hasColumn('certificates', 'event_id')) {
                    $table->foreignId('event_id')->nullable()->after('user_id')->constrained()->nullOnDelete();
                }
                if (!Schema::hasColumn('certificates', 'code')) {
                    $table->string('code')->unique()->after('event_id');
                }
                if (!Schema::hasColumn('certificates', 'issued_at')) {
                    $table->timestamp('issued_at')->nullable()->after('code');
                }
                if (!Schema::hasColumn('certificates', 'status')) {
                    $table->string('status')->default('issued')->after('issued_at');
                }
                if (!Schema::hasColumn('certificates', 'created_at')) {
                    $table->timestamps();
                }
            });
        }
    }

    public function down(): void {
        if (Schema::hasTable('certificates')) {
            Schema::drop('certificates');
        }
    }
};
