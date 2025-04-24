<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\ClassPageController;
use Illuminate\Http\Request;

// Root Route (Login Page)
Route::get('/', function () {
    return view('auth.login');
})->name('welcome');

// Authentication Routes (User)
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Landing Page Route
Route::get('/landingpage', [AuthController::class, 'landingpage'])->name('landingpage')->middleware('auth');

// Dashboard Route (handled by ClassPageController)
Route::get('/dashboard', [ClassPageController::class, 'index'])->name('dashboard')->middleware('auth');

// Public Routes
Route::get('/home', function () {
    return view('home');
})->name('home');

Route::get('/about', function () {
    return view('about');
})->name('about');

// Admin Authentication Routes
Route::get('/admin/login', function () {
    return view('auth.login');
})->name('admin.login');

Route::post('/admin/login', function (Request $request) {
    $username = $request->input('username');
    $password = $request->input('password');

    if ($username === 'admin' && $password === 'password123') {
        session(['is_admin' => true]);
        return redirect()->route('admin.dashboard');
    }

    return back()->withErrors(['Invalid credentials']);
})->name('admin.login.submit');

Route::post('/admin/logout', function () {
    session()->forget('is_admin');
    return redirect()->route('login');
})->name('admin.logout');

// Admin Routes (Protected)
Route::prefix('admin')->name('admin.')->middleware('admin')->group(function () {
    Route::get('/dashboard', [UserController::class, 'dashboard'])->name('dashboard');
    Route::put('/update/{id}', [UserController::class, 'update'])->name('update');
    Route::delete('/delete/{id}', [UserController::class, 'destroy'])->name('destroy');
});

// Testing Route
Route::get('/auth/test', function () {
    return view('auth.test');
})->name('auth.test');