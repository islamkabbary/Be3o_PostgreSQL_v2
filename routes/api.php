<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\AuthController;

Route::prefix('v1')->group(function () {
    Route::prefix('auth')->group(function () {
        // Registration & Authentication
        Route::post('/register', [AuthController::class, 'register']);
        Route::post('/login', [AuthController::class, 'login'])->middleware("throttle:5,1");
        Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

        // Email / Phone Verification
        Route::get('/verify/{token}', [AuthController::class, 'verify']);
        Route::post('/resend-verification', [AuthController::class, 'resendVerification'])->middleware("throttle:5,1");

        // Password Reset
        Route::post('/forgot-password', [AuthController::class, 'forgotPassword'])->middleware("throttle:5,1");
        Route::post('/reset-password', [AuthController::class, 'resetPassword']);
    });
});
