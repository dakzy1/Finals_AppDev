<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\FitnessClass;
use App\Models\Schedule;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function dashboard(Request $request)
    {
        $users = User::all();
        $fitnessClasses = FitnessClass::all();
        $schedules = Schedule::all();
        $editUser = null;
        $editClass = null;

        if ($request->has('edit')) {
            $editUser = User::find($request->input('edit'));
        }

        if ($request->has('edit_class')) {
            $editClass = FitnessClass::find($request->input('edit_class'));
        }

        return view('admin.dashboard', compact('users', 'editUser', 'fitnessClasses', 'schedules', 'editClass'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email'
        ]);

        $user = User::findOrFail($id);
        $user->update($request->only('name', 'email'));

        return redirect()->route('admin.dashboard')->with('success', 'User updated successfully.');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.dashboard')->with('success', 'User deleted successfully.');
    }

    // CRUD for FitnessClass
    public function storeFitnessClass(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'level' => 'required|string|max:255',
            'duration' => 'required|string|max:255',
            'trainer' => 'required|string|max:255',
        ]);

        FitnessClass::create($request->all());
        return redirect()->route('admin.dashboard')->with('success', 'Fitness Class added successfully');
    }

    public function updateFitnessClass(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'level' => 'required|string|max:255',
            'duration' => 'required|string|max:255',
            'trainer' => 'required|string|max:255',
        ]);

        $fitnessClass = FitnessClass::findOrFail($id);
        $fitnessClass->update($request->all());
        return redirect()->route('admin.dashboard')->with('success', 'Fitness Class updated successfully');
    }

    public function destroyFitnessClass($id)
    {
        $fitnessClass = FitnessClass::findOrFail($id);
        $fitnessClass->delete();
        return redirect()->route('admin.dashboard')->with('success', 'Fitness Class deleted successfully');
    }

    // CRUD for Schedule
    public function storeSchedule(Request $request)
    {
        $request->validate([
            'class_name' => 'required|string|max:255',
            'date' => 'required|date',
            'time' => 'required',
            'trainer' => 'required|string|max:255',
        ]);

        Schedule::create($request->all());
        return redirect()->route('admin.dashboard')->with('success', 'Schedule added successfully');
    }

    public function updateSchedule(Request $request, $id)
    {
        $request->validate([
            'class_name' => 'required|string|max:255',
            'date' => 'required|date',
            'time' => 'required',
            'trainer' => 'required|string|max:255',
        ]);

        $schedule = Schedule::findOrFail($id);
        $schedule->update($request->all());
        return redirect()->route('admin.dashboard')->with('success', 'Schedule updated successfully');
    }

    public function destroySchedule($id)
    {
        $schedule = Schedule::findOrFail($id);
        $schedule->delete();
        return redirect()->route('admin.dashboard')->with('success', 'Schedule deleted successfully');
    }
}