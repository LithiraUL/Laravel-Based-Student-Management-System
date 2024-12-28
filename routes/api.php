<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StudentController;

// Publicly accessible routes for authentication
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Routes protected by Sanctum authentication
Route::middleware('auth:sanctum')->group(function () {
    // Fetch all students
    Route::get('/students', [StudentController::class, 'index']);
    
    // Add a new student
    Route::post('/students', [StudentController::class, 'store']);

    // Fetch details of a specific student
    Route::get('/students/{id}', [StudentController::class, 'show']);

    // Update a specific student
    Route::put('/students/{id}', [StudentController::class, 'update']);

    // Delete a specific student
    Route::delete('/students/{id}', [StudentController::class, 'destroy']);
});

// Catch-all route for undefined API endpoints
Route::fallback(function () {
    return response()->json([
        'message' => 'API endpoint not found.'
    ], 404);
});




