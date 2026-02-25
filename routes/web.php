<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/email/verify/{id}/{hash}', [App\Http\Controllers\API\Auth\VerificationController::class, 'verify'])
    ->middleware(['signed'])
    ->name('verification.verify');

// مـعـمـل الاخـتـبار لـلـتـتـبع الـلـحـظـي (Real-time Test Lab)
Route::get('/test/tracking', [App\Http\Controllers\TestTrackingController::class, 'index']);
Route::post('/test/tracking/update', [App\Http\Controllers\TestTrackingController::class, 'updateLocation']);
