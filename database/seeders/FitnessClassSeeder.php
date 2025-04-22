<?php

namespace Database\Seeders;

use App\Models\FitnessClass;
use Illuminate\Database\Seeder;

class FitnessClassSeeder extends Seeder
{
    public function run(): void
    {
        FitnessClass::create([
            'name' => 'Yoga Class',
            'level' => 'Beginner',
            'duration' => '30 mins',
            'trainer' => 'Jaway',
        ]);
        FitnessClass::create([
            'name' => 'Zumba Class',
            'level' => 'Beginner',
            'duration' => '30 mins',
            'trainer' => 'Jaway',
        ]);
        FitnessClass::create([
            'name' => 'Pilates Class',
            'level' => 'Beginner',
            'duration' => '30 mins',
            'trainer' => 'Jaway',
        ]);
        FitnessClass::create([
            'name' => 'HIIT Class',
            'level' => 'Beginner',
            'duration' => '30 mins',
            'trainer' => 'Jaway',
        ]);
        FitnessClass::create([
            'name' => 'Strength Class',
            'level' => 'Beginner',
            'duration' => '30 mins',
            'trainer' => 'Jaway',
        ]);
    }
}