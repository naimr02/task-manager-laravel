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

// NEW: Mobile registration endpoint - matches your Flutter API call to /auth/register
Route::post('/auth/register', function (Request $request) {
    try {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8',
            'password_confirmation' => 'required|string|same:password',
            'device_name' => 'required|string',
        ]);

        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
        ]);

        $token = $user->createToken($validatedData['device_name'])->plainTextToken;

        return response()->json([
            'success' => true,
            'user' => $user,
            'token' => $token,
            'message' => 'Registration successful'
        ], 201);

    } catch (\Illuminate\Validation\ValidationException $e) {
        return response()->json([
            'success' => false,
            'message' => 'Validation failed',
            'errors' => $e->errors()
        ], 422);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Registration failed. Please try again.',
            'errors' => []
        ], 500);
    }
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
