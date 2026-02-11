<?php

use App\Http\Controllers\API\BrandController;
use App\Http\Middleware\setLang;
use Illuminate\Support\Facades\Route;

Route::middleware([setLang::class])->group(function () {
    Route::get('brands', [BrandController::class, 'index']);
});
