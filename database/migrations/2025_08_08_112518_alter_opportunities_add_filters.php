<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('opportunities', function (Blueprint $table) {
            if (!Schema::hasColumn('opportunities','slots')) {
                $table->unsignedInteger('slots')->default(0);
            }
            if (!Schema::hasColumn('opportunities','requirements')) {
                $table->text('requirements')->nullable();
            }
            if (!Schema::hasColumn('opportunities','category')) {
                $table->string('category')->nullable();
            }
            if (!Schema::hasColumn('opportunities','poster_path')) {
                $table->string('poster_path')->nullable();
            }
            if (!Schema::hasColumn('opportunities','application_deadline')) {
                $table->date('application_deadline')->nullable();
            }
        });
    }

    public function down(): void {
        Schema::table('opportunities', function (Blueprint $table) {
            if (Schema::hasColumn('opportunities','application_deadline')) $table->dropColumn('application_deadline');
            if (Schema::hasColumn('opportunities','poster_path')) $table->dropColumn('poster_path');
            if (Schema::hasColumn('opportunities','category')) $table->dropColumn('category');
            if (Schema::hasColumn('opportunities','requirements')) $table->dropColumn('requirements');
            // leave 'slots' in place (safe to keep); comment the next line in if you need to drop it:
            // if (Schema::hasColumn('opportunities','slots')) $table->dropColumn('slots');
        });
    }
};

