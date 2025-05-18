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
         // Validate all required fields
        $request->validate([
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'gender' => 'required|string|in:male,female,other',
            'email' => 'required|email|max:255',
            'password' => 'nullable|string|min:8', // Password is optional
        ]);

        $user = User::findOrFail($id);

        // Update user fields manually
        $user->first_name = $request->first_name;
        $user->middle_name = $request->middle_name;
        $user->last_name = $request->last_name;
        $user->gender = $request->gender;
        $user->email = $request->email;

        // Only update password if it is provided
        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }

        $user->save();

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
            'description' => 'required|string|max:255',
            'key_benefits' => 'required|string|max:255',
            'user_limit' => 'required|integer|min:1',
            'time' => 'required',
            'end_time' => 'required',
        ]);

        FitnessClass::create($request->all());
        return redirect()->route('admin.classmanage')->with('success', 'Fitness Class added successfully');
    }

    public function updateFitnessClass(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'level' => 'required|string|max:255',
            'duration' => 'required|string|max:255',
            'trainer' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'key_benefits' => 'required|string|max:255',
            'user_limit' => 'required|integer|min:1',
            'time' => 'required',
            'end_time' => 'required',
        ]);

    $fitnessClass = FitnessClass::findOrFail($id);
    $fitnessClass->update($request->all());
    return redirect()->route('admin.classmanage')
        ->with('success', 'Fitness Class updated successfully')
        ->with('message_type', 'success');    }

    public function destroyFitnessClass($id)
    {
    $fitnessClass = FitnessClass::findOrFail($id);
    $fitnessClass->delete();
    return redirect()->route('admin.classmanage')
        ->with('success', 'Fitness Class deleted successfully')
        ->with('message_type', 'danger');
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
    public function redirectToPage(Request $request)
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

        return view('admin.classmanage', compact('users', 'editUser', 'fitnessClasses', 'schedules', 'editClass'));
    }
    public function classManage(Request $request)
    {
        $editClass = null;
        if ($request->has('edit_class')) {
            $editClass = FitnessClass::find($request->input('edit_class'));
        }

        $fitnessClasses = FitnessClass::all();
        return view('admin.classmanage', compact('fitnessClasses', 'editClass'));
    }
    public function toggleStatus($id)
    {
        $user = User::findOrFail($id);
        $user->status = $user->status === 'active' ? 'deactivated' : 'active';
        $user->save();

        return redirect()->route('admin.dashboard')->with('success', 'User status updated successfully.');
    }


}