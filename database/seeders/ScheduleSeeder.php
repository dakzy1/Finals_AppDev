<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\FitnessClass;
use App\Models\Schedule;

class ScheduleSeeder extends Seeder
{
    public function run()
    {
        $users = User::all();
        $fitnessClasses = FitnessClass::all();

        if ($users->isEmpty() || $fitnessClasses->isEmpty()) {
            throw new \Exception('Please seed Users and FitnessClasses before seeding Schedules.');
        }

        $schedules = [
            [
                'user_id' => $users->random()->id,
                'class_id' => $fitnessClasses->random()->id,
                'date' => '2025-05-01',
                'time' => '09:00',
                'trainer' => 'Alice Smith',
            ],
            [
                'user_id' => $users->random()->id,
                'class_id' => $fitnessClasses->random()->id,
                'date' => '2025-05-02',
                'time' => '18:00',
                'trainer' => 'Bob Johnson',
            ],
        ];

        foreach ($schedules as $schedule) {
            Schedule::create($schedule);
        }
    }
}