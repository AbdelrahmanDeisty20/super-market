<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\BrandController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\ProductController;
use App\Http\Middleware\CheckUserStatus;
use App\Http\Middleware\setLang;
use Illuminate\Auth\Middleware\EnsureEmailIsVerified;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'v1', 'middleware' => [setLang::class]], function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/email/verify/{id}/{hash}', [AuthController::class, 'verify'])
        ->middleware(['signed'])
        ->name('verification.verify');

    Route::post('/email/verification-resend', [AuthController::class, 'resend'])
        ->middleware(['throttle:6,1'])
        ->name('verification.send');

    Route::post('/login', [AuthController::class, 'login']);
    Route::get('categories', [CategoryController::class, 'index']);
    Route::get('brands', [BrandController::class, 'index']);
    Route::get('products', [ProductController::class, 'index']);

    Route::group(['middleware' => ['verified', 'auth:sanctum']], function () {
        Route::put('/profile', [AuthController::class, 'profile']);
        Route::post('/logout', [AuthController::class, 'logout']);
    });
});

// Example of how to use verification middleware (requires auth)
// Route::middleware(['auth:sanctum', 'verified'])->group(function () { ... });

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
