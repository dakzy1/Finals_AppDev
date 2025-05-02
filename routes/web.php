<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\ClassPageController;
use App\Http\Controllers\ProfileController;


use Illuminate\Http\Request;   

Route::get('/', function () {
    return view('auth.login');
});

// Authentication Routes (User)
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/landingpage', [ClassPageController::class, 'landingpage'])->name('landingpage');

// Dashboard Route (handled by ClassPageController)
Route::get('/dashboard', [ClassPageController::class, 'index'])->name('dashboard')->middleware('auth');

//Profile
Route::middleware('auth')->group(function () {
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/profile/delete', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


// Viewclass Route
Route::get('/viewclass/{id}', [ClassPageController::class, 'viewClass'])->name('viewclass')->middleware('auth');

// Booking Routes
Route::get('/class/{id}/book', [ClassPageController::class, 'bookclass'])->name('bookclass');
Route::post('/class/{id}/book', [ClassPageController::class, 'store'])->name('bookclass.store');
Route::put('/class//{id}/book', [ClassPageController::class, 'update'])->name('bookclass.update');


// Public Routes
Route::get('/about', function () {
    return view('about');
})->name('about');

//  ADMIN FUNCTION
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

// FitnessClass CRUD
Route::post('/class/store', [UserController::class, 'storeFitnessClass'])->name('class.store');
Route::put('/class/update/{id}', [UserController::class, 'updateFitnessClass'])->name('class.update');
Route::delete('/class/delete/{id}', [UserController::class, 'destroyFitnessClass'])->name('class.destroy');

// Admin logout
Route::post('/admin/logout', function () {
    session()->forget('is_admin');
    return redirect()->route('auth.login');
})->name('admin.logout');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [UserController::class, 'dashboard'])->name('dashboard');
    Route::get('/admin/classmanage', [UserController::class, 'classManage'])->name('admin.classmanage');
    Route::get('/classmanage', [UserController::class, 'redirectToPage'])->name('classmanage');
    Route::put('/update{id}', [UserController::class, 'update'])->name('update');
    Route::delete('/delete{id}', [UserController::class, 'destroy'])->name('destroy');
});

 // testing phase
Route::get('/auth/test', function () {
    return view ('auth.test');
})->name('auth.test');

// Redirect to homepage
Route::get('/home', function () {
    return view('home'); 
})->name('home');

// routes/web.php
Route::get('/classmanagement', [UserController::class, 'redirectToPage'])->name('redirect.page');
