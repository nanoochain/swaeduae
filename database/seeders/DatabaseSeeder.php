<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Event;
use App\Models\Volunteer;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Admin user
        User::firstOrCreate([
            'email' => 'admin@swaeduae.ae',
        ], [
            'name' => 'Admin User',
            'password' => Hash::make('secret123'),
            'role' => 'admin',
        ]);

        // Sample Volunteer user
        $volUser = User::firstOrCreate([
            'email' => 'volunteer@swaeduae.ae',
        ], [
            'name' => 'Volunteer User',
            'password' => Hash::make('secret123'),
            'role' => 'volunteer',
        ]);

        Volunteer::firstOrCreate([
            'user_id' => $volUser->id,
            'phone' => '0500000000',
            'kyc_status' => 'approved',
        ]);

        // Sample events
        Event::firstOrCreate(['title' => 'Beach Cleanup'], [
            'description' => 'Join us to clean the beach.',
            'location' => 'Dubai Beach',
            'start_time' => now()->addDays(5),
            'end_time' => now()->addDays(5)->addHours(3),
            'status' => 'upcoming',
        ]);

        Event::firstOrCreate(['title' => 'Tree Planting'], [
            'description' => 'Help plant trees in the park.',
            'location' => 'Abu Dhabi Park',
            'start_time' => now()->addDays(10),
            'end_time' => now()->addDays(10)->addHours(4),
            'status' => 'upcoming',
        ]);
    }
}
