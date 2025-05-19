<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\FitnessClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ClassPageController extends Controller
{
    /**
     * Dashboard: show all classes and user's booked schedules
     */
    public function index()
    {
        $user = Auth::user();

        $schedules = Schedule::where('user_id', $user->id)
            ->with('fitnessClass')
            ->get();

        $classes = FitnessClass::all();

        return view('dashboard', compact('schedules', 'classes'));
    }

    /**
     * Landing Page: show upcoming class for the logged-in user
     */
    public function upcomSchedule()
    {
        $userId = Auth::id();

        $upcomingSchedule = Schedule::where('user_id', $userId)
            ->whereHas('fitnessClass')
            ->with('fitnessClass')
            ->orderBy('created_at')
            ->first();

        if ($upcomingSchedule) {
            $upcomingSchedule->date = Carbon::parse($upcomingSchedule->date)->format('Y-m-d');
            $upcomingSchedule->time = Carbon::parse($upcomingSchedule->time)->format('H:i');
        }

        // Add these:
        $schedules = Schedule::where('user_id', $userId)->with('fitnessClass')->get();
        $classes = FitnessClass::with('schedules')->get(); // Assuming you have a FitnessClass model
        

        return view('dashboard', compact('upcomingSchedule', 'schedules', 'classes'));
    }



    /**
     * View a specific class and the user's schedules for that class
     */
    public function viewClass($id)
    {
        $user = Auth::user();
        $class = FitnessClass::findOrFail($id);
    
        // Fetch *all* schedules booked by the user, not just for this class
        $schedules = Schedule::where('user_id', $user->id)
            ->with('fitnessClass')
            ->get();
    
        return view('viewclass', compact('class', 'schedules'));
    }
    

    /**
     * Book class form
     */
    public function bookClass($id)
    {
        $class = FitnessClass::findOrFail($id);
    
        // Get the user's existing bookings for the given class
        $user = Auth::user();
        $existingBookings = Schedule::where('user_id', $user->id)
                                    ->where('class_id', $class->id)
                                    ->get(['date', 'time']);  // Only fetch relevant fields
    
        // Pass existing bookings and class to the view
        return view('bookclass', compact('class', 'existingBookings'));
    }

    /**
     * Store a new booking
     */
    public function store(Request $request, $id)
    {
        $validated = $request->validate([
            'trainer' => 'required|string|max:255',
            'time' => 'required',
            'date' => ['required', 'date', 'after_or_equal:today'],
        ]);
    
        $user = Auth::user();
        $class = FitnessClass::findOrFail($id);
    
        
        $selectedTime = Carbon::parse($validated['time'])->format('H:i');
    
        $hasConflict = Schedule::where('user_id', $user->id)
            ->where('time', $selectedTime)
            ->first();

        if ($hasConflict) {
            
            $conflictTime = Carbon::parse($hasConflict->time)->format('h:i A');
            $warningMessage = "You already have a booking at {$conflictTime}.";

            $existingBookings = Schedule::where('user_id', $user->id)->get(['time']);

            return view('bookclass', compact('class', 'existingBookings', 'warningMessage'));
        }
    
        Schedule::create([
            'user_id' => $user->id,
            'class_id' => $class->id,
            'date' => $validated['date'],
            'time' => $selectedTime,
            'trainer' => $validated['trainer'],
        ]);
    
            return redirect()->route('dashboard')
                ->with('success', 'Class booked successfully!')
                ->with('message_type', 'success');
    }

    /**
     * Update a scheduled class (currently unused if you're only viewing schedules)
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'date' => 'required|date',
            'time' => 'required',
            'trainer' => 'required|string|max:255',
        ]);

        $schedule = Schedule::findOrFail($id);
        $schedule->update([
            'date' => $request->date,
            'time' => $request->time,
            'trainer' => $request->trainer,
        ]);

        return redirect()->back()->with('success', 'Schedule updated successfully.');
    }

    /**
     * Delete a scheduled class
     */
    public function destroy($id)
    {
        $schedule = Schedule::findOrFail($id);
        $schedule->delete();

        return redirect()->back()
            ->with('success', 'Schedule deleted successfully!')
            ->with('message_type', 'danger');
    }
}
