<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuthModel extends Model
{
    use HasFactory;

    protected $table = 'data';

    protected $fillable = [
        'name', 'email', 'password',
    ];
}
