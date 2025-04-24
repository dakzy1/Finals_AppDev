<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FitnessClass extends Model
{
    use HasFactory;

    protected $table = 'classes'; // Important: This tells Laravel to use the 'classes' table

    protected $fillable = [
        'name',
        'level',
        'duration',
        'trainer',
    ];

    public function schedules()
    {
        return $this->hasMany(Schedule::class, 'class_id');
    }
}
