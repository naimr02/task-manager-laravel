<?php
// routes/api.php

use App\Http\Controllers\Api\TaskController;
use App\Http\Controllers\Api\CategoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Models\User;

// Mobile authentication endpoint (MUST be outside auth middleware)
Route::post('/auth/mobile-login', function (Request $request) {
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
        'device_name' => 'required',
    ]);

    $user = User::where('email', $request->email)->first();

    if (! $user || ! Hash::check($request->password, $user->password)) {
        throw ValidationException::withMessages([
            'email' => ['The provided credentials are incorrect.'],
        ]);
    }

    $token = $user->createToken($request->device_name)->plainTextToken;

    return response()->json([
        'user' => $user,
        'token' => $token,
    ]);
});

// Protected routes requiring authentication
Route::middleware('auth:sanctum')->group(function () {
    // User endpoint - SINGLE DEFINITION
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    
    // Logout endpoint
    Route::post('/auth/logout', function (Request $request) {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Logged out successfully']);
    });
    
    // Resource routes for CRUD operations
    Route::apiResource('tasks', App\Http\Controllers\Api\TaskController::class);
    Route::apiResource('categories', App\Http\Controllers\Api\CategoryController::class);
});
