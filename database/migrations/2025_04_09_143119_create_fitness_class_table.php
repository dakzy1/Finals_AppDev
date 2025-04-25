<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fitness_classes', function (Blueprint $table) { // Changed to fitness_classes
            $table->id();
            $table->timestamps();
            $table->date('date');
            $table->time('time');
            $table->string('category');
            $table->string('trainer');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fitness_classes'); // Changed to fitness_classes
    }
};