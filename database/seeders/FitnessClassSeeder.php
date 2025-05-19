<?php

namespace Database\Seeders;

use App\Models\FitnessClass;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class FitnessClassSeeder extends Seeder
{
    public function run(): void
    {
        $classNames = [
            'Yoga', 'Zumba', 'Pilates', 'HIIT', 'Strength'
        ];

        $levels = ['Beginner', 'Intermediate', 'Advanced'];
        $trainers = ['Jaway', 'Alex', 'Kim', 'Dana', 'Luis', 'Sam', 'Taylor', 'Jordan'];

        for ($i = 1; $i <= 70; $i++) {
            $class = $classNames[array_rand($classNames)];
            $level = $levels[array_rand($levels)];
            $trainer = $trainers[array_rand($trainers)];

            // Random start time between 6:00 AM and 6:00 PM
            $startHour = rand(6, 17);
            $startMinute = rand(0, 1) ? '00' : '30';
            $startTime = sprintf('%02d:%s', $startHour, $startMinute);

            // End time = start time + 30 minutes
            $endTimestamp = strtotime("$startTime +30 minutes");
            $endTime = date('H:i', $endTimestamp);

            FitnessClass::create([
                'name' => $class,
                'level' => $level,
                'duration' => '30 mins',
                'trainer' => $trainer,
                'time' => $startTime,
                'end_time' => $endTime,
            ]);
        }
    }
}
