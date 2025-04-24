<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\FitnessClass;
use Illuminate\Http\Request;

class ClassPageController extends Controller
{
    public function index()
    {
        $schedules = Schedule::all();
        $classes = FitnessClass::all();
        return view('dashboard', compact('schedules', 'classes'));
    }
}