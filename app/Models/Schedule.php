<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $table = 'schedules'; // Explicitly set to bookings table

    protected $fillable = [
        'user_id',
        'class_id',
        'trainer',
        'time',
        'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function fitnessClass()
    {
        return $this->belongsTo(FitnessClass::class, 'class_id');
    }
}