<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->timestamps();
        });

        // Seed default keys with empty values
        DB::table('settings')->insert([
            ['key' => 'stripe_api_key', 'value' => ''],
            ['key' => 'paytabs_api_key', 'value' => ''],
            ['key' => 'whatsapp_api_key', 'value' => ''],
            ['key' => 'whatsapp_instance_id', 'value' => ''],
            ['key' => 'whatsapp_number', 'value' => ''],
            ['key' => 'google_maps_api_key', 'value' => ''],
            ['key' => 'uaepass_client_id', 'value' => ''],
            ['key' => 'facebook_app_id', 'value' => ''],
            ['key' => 'other_api_key', 'value' => ''],
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('settings');
    }
}
