<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fitness_classes', function (Blueprint $table) {
            $table->id();
            $table->string('name');        // Added to store the class name
            $table->string('level');       // Added to store the difficulty level
            $table->string('duration');    // Added to store the duration (e.g., "60 mins")
            $table->string('trainer');     // Existing column
            $table->date('date')->nullable();         // Existing column
            $table->time('time')->nullable();         // Existing column
            $table->string('category')->nullable();    // Existing column
            $table->timestamps();          // Existing, adds created_at and updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fitness_classes');
    }
};