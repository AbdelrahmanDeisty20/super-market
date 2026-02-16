<?php

use App\Http\Controllers\API\Auth\AuthController;
use App\Http\Controllers\API\Auth\VerificationController;
use App\Http\Controllers\API\BrandController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\CouponController;
use App\Http\Controllers\API\OfferController;
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

    Route::get('offers', [OfferController::class, 'index']);
    Route::get('offer/{id}', [OfferController::class, 'show']);

    Route::get('coupons', [CouponController::class, 'index']);
    Route::post('coupon/check', [CouponController::class, 'check']);
    Route::get('settings', [\App\Http\Controllers\API\SettingController::class, 'index']);
    Route::get('settings/{key}', [\App\Http\Controllers\API\SettingController::class, 'show']);

    Route::get('services', [\App\Http\Controllers\API\ServiceController::class, 'index']);
    Route::get('pages', [\App\Http\Controllers\API\PageController::class, 'index']);
    Route::get('pages/{slug}', [\App\Http\Controllers\API\PageController::class, 'show']);
    Route::post('contact', [\App\Http\Controllers\API\ContactController::class, 'store']);

    // Protected routes
    Route::middleware(['auth:sanctum', 'verified'])->group(function () {
        Route::get('profile', [AuthController::class, 'profile']);
        Route::put('profile', [AuthController::class, 'update']);
        Route::post('logout', [AuthController::class, 'logout']);
        Route::delete('profile', [AuthController::class, 'destroy']);
    });
});