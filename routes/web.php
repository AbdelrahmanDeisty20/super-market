<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/email/verify/{id}/{hash}', [App\Http\Controllers\API\Auth\VerificationController::class, 'verify'])
    ->middleware(['signed'])
    ->name('verification.verify');
