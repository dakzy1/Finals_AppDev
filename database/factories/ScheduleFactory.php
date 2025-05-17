<?php

namespace Database\Factories;
use App\Models\Schedule;
use App\Models\User;
use App\Models\FitnessClass;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Schedule>
 */
class ScheduleFactory extends Factory
{
    protected $model = Schedule::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'class_id' => FitnessClass::factory(),
            'date' => $this->faker->dateTimeBetween('now', '+1 month')->format('Y-m-d'),
            'time' => $this->faker->time('H:i'),
            'trainer' => $this->faker->name,
        ];
    }
}
