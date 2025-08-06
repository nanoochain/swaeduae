<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Event;
use App\Models\News;

class DemoHomeSeeder extends Seeder
{
    public function run()
    {
        // Create sample events if none exist
        if (Event::count() == 0) {
            Event::create([
                'title' => 'Beach Cleanup Dubai',
                'description' => 'Join us for a fun and impactful beach cleanup in Jumeirah.',
                'city' => 'Dubai',
                'date' => now()->addDays(7),
            ]);
            Event::create([
                'title' => 'Sharjah Library Volunteering',
                'description' => 'Help organize books and assist young readers.',
                'city' => 'Sharjah',
                'date' => now()->addDays(14),
            ]);
            Event::create([
                'title' => 'Online Tutoring Session',
                'description' => 'Support students with online tutoring in math and science.',
                'city' => null,
                'date' => now()->addDays(21),
            ]);
        }

        // Create sample news if none exist
        if (News::count() == 0) {
            News::create([
                'title' => 'Sawaed UAE Launches New Platform',
                'body' => 'We are excited to announce the launch of our new volunteer portal!',
            ]);
            News::create([
                'title' => 'Volunteer of the Month: Ayesha Ali',
                'body' => 'Congratulations to Ayesha for her dedication and commitment.',
            ]);
            News::create([
                'title' => 'Summer Opportunities Now Open',
                'body' => 'Check out the latest summer volunteer opportunities across the UAE.',
            ]);
        }
    }
}
