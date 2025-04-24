<?php

namespace Database\Seeders;

use App\Models\Schedule;
use Illuminate\Database\Seeder;

class ScheduleSeeder extends Seeder
{
    public function run(): void
    {
        Schedule::create([
            'class_name' => 'Yoga Class',
            'date' => '2025-04-10',
            'time' => '16:00:00',
            'trainer' => 'Irvin Jaway',
        ]);
        Schedule::create([
            'class_name' => 'Strength Class',
            'date' => '2025-04-11',
            'time' => '18:00:00',
            'trainer' => 'Jane Doe',
        ]);
    }
}