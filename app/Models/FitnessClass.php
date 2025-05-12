<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FitnessClass extends Model
{
    use HasFactory;

    protected $table = 'fitness_classes'; // Changed to fitness_classes

    protected $fillable = [ 
        'name', 
        'level',
        'duration',
        'trainer',
        'date',
        'time',
        'category',
        'description',
        'key_benefits',
        'user_limit',
        'end_time',
    ];

    public function schedules()
    {
        return $this->hasMany(Schedule::class, 'class_id');
    }
    public function bookedUsers()
    {
        return $this->hasMany(Schedule::class, 'class_id')->distinct('user_id');
    }
    

}