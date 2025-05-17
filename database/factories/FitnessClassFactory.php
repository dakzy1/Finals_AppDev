<?php

namespace Database\Factories;
use App\Models\FitnessClass;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\FitnessClass>
 */
class FitnessClassFactory extends Factory
{
    protected $model = FitnessClass::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->word(),
            'level' => $this->faker->randomElement(['Beginner', 'Intermediate', 'Advanced']),
            'duration' => $this->faker->numberBetween(30, 90) . ' mins',
            'trainer' => $this->faker->name(),
            'description' => $this->faker->sentence(),
            'key_benefits' => $this->faker->words(3, true),
            'user_limit' => $this->faker->numberBetween(10, 50),
            'time' => $this->faker->time('H:i'),
            'end_time' => $this->faker->time('H:i'),
        ];
    }
}
