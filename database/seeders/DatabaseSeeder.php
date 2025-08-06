<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Call your demo seeder here!
        $this->call([
            DemoHomeSeeder::class,
        ]);
    }
}
