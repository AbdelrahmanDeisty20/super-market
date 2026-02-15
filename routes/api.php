<?php

use App\Http\Controllers\API\Auth\AuthController;
use App\Http\Controllers\API\Auth\VerificationController;
use App\Http\Controllers\API\BrandController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\ProductController;
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

    // Password Reset
    Route::post('forgot-password', [App\Http\Controllers\API\Auth\ForgotPasswordController::class, 'sendResetLinkEmail']);
    Route::get('password/verify/{token}', [App\Http\Controllers\API\Auth\PasswordLinkConfirmationController::class, 'verify'])->name('api.password.verify');
    Route::post('reset-password', [App\Http\Controllers\API\Auth\ResetPasswordController::class, 'reset']);

    Route::get('brands', [BrandController::class, 'index']);
    Route::get('brand/{id}', [BrandController::class, 'show']);

    Route::get('categories', [CategoryController::class, 'index']);
    Route::get('category/{id}', [CategoryController::class, 'show']);

    Route::get('products', [ProductController::class, 'index']);
    Route::get('product/may-like', [ProductController::class, 'mayLike']);
    Route::get('product/{id}', [ProductController::class, 'show']);
    Route::get('product/{id}/related', [ProductController::class, 'related']);
    Route::get('isFeatured', [ProductController::class, 'isFeatured']);
    Route::get('onSale', [ProductController::class, 'onSale']);

    // Protected routes
    Route::middleware(['auth:sanctum', 'verified'])->group(function () {
        Route::get('profile', [AuthController::class, 'profile']);
        Route::put('profile', [AuthController::class, 'update']);
        Route::post('logout', [AuthController::class, 'logout']);
        Route::delete('profile', [AuthController::class, 'destroy']);
    });
});
