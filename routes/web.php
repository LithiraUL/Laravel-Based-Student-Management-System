<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\RoleMiddleware;
// ---------------------------------------------
// Web Routes: Handles session-based authentication
// ---------------------------------------------
// Register Middleware for RoleMiddleware
Route::aliasMiddleware('role', RoleMiddleware::class);
// Redirect to login page by default
Route::get('/', function () {
    return redirect()->route('login');
});

// Dashboard route (redirects to the welcome page)
Route::get('/dashboard', function () {
    return redirect()->route('welcome');
})->middleware(['auth', 'verified'])->name('dashboard');

// Profile management routes (protected with 'auth')
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ---------------------------------------------
// Auth Routes: Combined Login and Registration
// ---------------------------------------------

// Combined Login and Registration Form (Shared View)
Route::get('/login', [AuthController::class, 'showLoginRegisterForm'])->name('login');
Route::get('/register', [AuthController::class, 'showLoginRegisterForm'])
    ->name('register')
    ->middleware('guest');

// Handle Combined Login or Registration Action
Route::post('/login-register', [AuthController::class, 'loginOrRegister'])->name('login-register');

// Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ---------------------------------------------
// Student Routes: Protected with 'auth'
// ---------------------------------------------

Route::middleware('auth')->group(function () {
    // Welcome Page (List of Students)
    Route::get('/welcome', [StudentController::class, 'index'])->name('welcome');

    // Students Management Routes
    Route::get('/students', [StudentController::class, 'index'])->name('students.index'); // List students
    Route::get('/students/create', [StudentController::class, 'create'])->name('students.create'); // Add student form
    Route::post('/students', [StudentController::class, 'store'])->name('students.store'); // Store student
    Route::get('/students/{id}/edit', [StudentController::class, 'edit'])->name('students.edit'); // Edit student
    Route::put('/students/{id}', [StudentController::class, 'update'])->name('students.update'); // Update student

    // Delete student (admin-only route)
    Route::delete('/students/{id}', [StudentController::class, 'destroy'])
    ->middleware(['auth', 'role:admin'])
    ->name('students.destroy');


    // Search Routes
    Route::get('/students/search', [StudentController::class, 'searchById'])->name('students.search'); // Search student by ID
});

// ---------------------------------------------
// Fallback for 404 Errors
// ---------------------------------------------
Route::fallback(function () {
    return response()->view('errors.404', [], 404);
});
