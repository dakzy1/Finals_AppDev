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
        $user = Auth::user();
        $schedules = Schedule::where('user_id', $user->id)->with('fitnessClass')->get();       
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

    public function store(Request $request)
    {
        // Validate the incoming request data
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'level' => 'required|string|max:255',
            'duration' => 'required|string|max:255',
            'trainer' => 'required|string|max:255',
            'date' => 'nullable|date',  // Optional
            'time' => 'nullable|date_format:H:i',  // Optional
            'category' => 'nullable|string|max:255',  // Optional
        ]);

        // Create the FitnessClass
        $fitnessClass = FitnessClass::create([
            'name' => $validated['name'],
            'level' => $validated['level'],
            'duration' => $validated['duration'],
            'trainer' => $validated['trainer'],
            'date' => $validated['date'] ?? null,
            'time' => $validated['time'] ?? null,
            'category' => $validated['category'] ?? null,
        ]);

        // Create a Schedule entry for the logged-in user
        $user = Auth::user();
        Schedule::create([
            'user_id' => $user->id,
            'class_id' => $fitnessClass->id,
            'date' => $validated['date'] ?? now()->toDateString(),  // Default to today if not provided
            'time' => $validated['time'] ?? now()->format('H:i'),   // Default to now if not provided
            'trainer' => $validated['trainer'],
        ]);

        return redirect()->route('dashboard')->with('success', 'Class booked successfully!');
    }
}