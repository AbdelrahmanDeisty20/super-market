<?php

use App\Http\Controllers\API\Auth\AuthController;
use App\Http\Controllers\API\Auth\VerificationController;
use App\Http\Controllers\API\BrandController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Middleware\setLang;
use Illuminate\Support\Facades\Route;

Route::middleware([setLang::class])->group(function () {
    // Public routes
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);

    // Email Verification
    Route::post('email/resend', [VerificationController::class, 'resend']);
    Route::get('email/verify/{id}/{hash}', [VerificationController::class, 'verify'])
        ->name('api.verification.verify');

    Route::get('brands', [BrandController::class, 'index']);
    Route::get('categories', [CategoryController::class, 'index']);

    // Protected routes
    Route::middleware(['auth:sanctum', 'verified'])->group(function () {
        Route::get('profile', [AuthController::class, 'profile']);
        Route::put('profile', [AuthController::class, 'update']);
        Route::post('logout', [AuthController::class, 'logout']);
        Route::post('refresh-token', [AuthController::class, 'refresh']);
        Route::delete('profile', [AuthController::class, 'destroy']);
    });
});
