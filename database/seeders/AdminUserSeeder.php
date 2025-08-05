<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        User::firstOrCreate(
            ['email' => 'admin@swaeduae.ae'],
            [
                'name' => 'Admin',
                'password' => Hash::make('secret123'),
                'role' => 'admin'
            ]
        );
    }
}
