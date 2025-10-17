<?php

use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\CategoryController;
use App\Http\Controllers\Api\V1\UserController;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Versioned API routes for the application.
| Each version is isolated for better maintainability.
| Default version: v1
|
*/

Route::prefix('v1')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Authentication Routes
    |--------------------------------------------------------------------------
    |
    | Routes related to user registration, login, logout,
    | email verification, and password recovery.
    |
    | Throttling is applied to prevent brute-force attacks.
    |
    */
    Route::prefix('auth')->group(function () {

        // ─── Registration & Login ────────────────────────────────────────────────
        Route::post('register', [AuthController::class, 'register']);
        Route::post('login', [AuthController::class, 'login'])
            ->middleware('throttle:5,1');
        Route::post('logout', [AuthController::class, 'logout'])
            ->middleware('auth:sanctum');

        // ─── Email Verification ─────────────────────────────────────────────────
        Route::get('verify/{token}', [AuthController::class, 'verify']);
        Route::post('resend-verification', [AuthController::class, 'resendVerification'])
            ->middleware('throttle:5,1');

        // ─── Password Reset ─────────────────────────────────────────────────────
        Route::post('forgot-password', [AuthController::class, 'forgotPassword'])
            ->middleware('throttle:5,1');
        Route::post('reset-password', [AuthController::class, 'resetPassword']);
    });


    /*
    |--------------------------------------------------------------------------
    | User Profile Routes
    |--------------------------------------------------------------------------
    |
    | Protected routes for managing the authenticated user's profile.
    | Includes profile retrieval, updates, and avatar upload.
    |
    */
    Route::middleware('auth:sanctum')->prefix('user')->group(function () {
        Route::get('profile', [UserController::class, 'profile']);
        Route::put('profile', [UserController::class, 'updateProfile']);
    });
    
    Route::get('/categories', [CategoryController::class, 'index']);
    Route::get('categories/{id}/children', [CategoryController::class, 'children']);
});