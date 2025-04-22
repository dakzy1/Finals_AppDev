<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Http\Request;   

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard')->middleware('auth');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');



Route::get('/auth/login', function () {
    return view('auth.login');
})->name('auth.login');

// Handle login form submission
Route::post('/admin/login', function (Request $request) {
    $username = $request->input('username');
    $password = $request->input('password');

    if ($username === 'admin' && $password === 'password123') {
        session(['is_admin' => true]);
        return redirect('/admin/dashboard');
    }

    return back()->withErrors(['Invalid credentials']);
})->name('admin.login.submit');

// Admin dashboard route (requires login)
Route::get('/admin/dashboard', function () {
    if (!session('is_admin')) {
        return redirect()->route('admin.login');
    }
    return view('admin.dashboard');
})->name('admin.dashboard');

// Admin logout
Route::post('/admin/logout', function () {
    session()->forget('is_admin');
    return redirect()->route('auth.login');
})->name('admin.logout');


Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [UserController::class, 'dashboard'])->name('dashboard');
    Route::put('/update{id}', [UserController::class, 'update'])->name('update');
    Route::delete('/delete{id}', [UserController::class, 'destroy'])->name('destroy');
});



