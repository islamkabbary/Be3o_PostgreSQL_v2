<?php

use App\Http\Controllers\Api\V1\AdvertisementController;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\CategoryController;
use App\Http\Controllers\Api\V1\UserController;
use App\Http\Middleware\CorsMiddleware;
use App\Http\Middleware\SetLanguageMiddleware;
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

Route::prefix('v1')->middleware([CorsMiddleware::class, SetLanguageMiddleware::class, 'throttle:60,1'])->group(function () {
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
    
    // Category
    Route::get('/categories', [CategoryController::class, 'index']);
    Route::get('categories/{id}/children', [CategoryController::class, 'children']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/user/profile', [UserController::class, 'profile']);
        Route::put('/user/profile', [UserController::class, 'updateProfile']);

        // Category
        Route::get('/categories/{id}/attributes', [CategoryController::class, 'listAttributes']);

        // ADS
        Route::Post('/create-ads', [AdvertisementController::class, 'createAds']);
    });
});
