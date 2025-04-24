<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\FitnessClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClassPageController extends Controller
{
    public function index()
    {
        $schedules = Schedule::all();
        $classes = FitnessClass::all();
        return view('dashboard', compact('schedules', 'classes'));
    }

    public function viewClass($id)
    {
        $class = FitnessClass::findOrFail($id);
        // Fetch schedules for this class, optionally filtered by the authenticated user
        $schedules = Schedule::where('class_id', $id)
                            ->where('user_id', Auth::id()) // Optional: show only the user's schedules
                            ->with('fitnessClass')
                            ->get();
        return view('viewclass', compact('class', 'schedules'));
    }

    public function bookClass($id)
    {
        $class = FitnessClass::findOrFail($id);
        return view('bookclass', compact('class'));
    }

    public function store(Request $request, $id)
    {
        $request->validate([
            'trainer' => 'required|string|max:255',
            'time' => 'required|string',
            'date' => 'required|date|after_or_equal:today',
        ]);

        Schedule::create([
            'user_id' => Auth::id(),
            'class_id' => $id,
            'trainer' => $request->trainer,
            'time' => $request->time,
            'date' => $request->date,
        ]);

        return redirect()->route('dashboard')->with('success', 'Class booked successfully!');
    }
}