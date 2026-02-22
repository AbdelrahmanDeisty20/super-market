<?php


use Illuminate\Http\Request;

use App\Http\Controllers\API\Auth\AuthController;
use App\Http\Controllers\API\Auth\VerificationController;
use App\Http\Controllers\API\BrandController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\CouponController;
use App\Http\Controllers\API\OfferController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\UnitController;
use App\Http\Controllers\API\UserAddressController;
use App\Http\Controllers\API\NotificationController;
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

    Route::get('units', [UnitController::class, 'index']);
    Route::get('banners', [\App\Http\Controllers\API\BannerController::class, 'index']);
    Route::get('faqs', [\App\Http\Controllers\API\FaqController::class, 'index']);
    Route::get('testimonials', [\App\Http\Controllers\API\TestimonialController::class, 'index']);
    Route::get('reviews/{product_id}', [\App\Http\Controllers\API\ReviewController::class, 'index']);

    // Protected routes
    Route::middleware(['auth:sanctum', 'verified'])->group(function () {
        Route::get('profile', [AuthController::class, 'profile']);
        Route::put('profile', [AuthController::class, 'update']);
        Route::post('logout', [AuthController::class, 'logout']);
        Route::post('logout-all', [AuthController::class, 'logoutAll']);
        Route::delete('profile', [AuthController::class, 'destroy']);

        // FCM Token
        Route::post('profile/fcm-token', [NotificationController::class, 'updateToken']);

        // Notifications
        Route::get('notifications', [NotificationController::class, 'index']);
        Route::put('notifications/{id}/read', [NotificationController::class, 'markAsRead']);
        Route::put('notifications/read-all', [NotificationController::class, 'markAllAsRead']);

        // Measurement Units
        Route::get('units', [UnitController::class, 'index']);

        // User Addresses
        Route::delete('addresses/delete-all', [UserAddressController::class, 'deleteAll']);
        Route::delete('addresses/{id}', [UserAddressController::class, 'destroy']);
        Route::apiResource('addresses', UserAddressController::class)->except(['destroy']);

        // Wishlist
        Route::get('wishlist', [\App\Http\Controllers\API\WhishlistController::class, 'index']);
        Route::post('wishlist', [\App\Http\Controllers\API\WhishlistController::class, 'toggle']);
        Route::delete('wishlist', [\App\Http\Controllers\API\WhishlistController::class, 'destroy']);

        // Review CRUD
        Route::get('my-reviews', [\App\Http\Controllers\API\ReviewController::class, 'myReviews']);
        Route::delete('reviews/delete-all', [\App\Http\Controllers\API\ReviewController::class, 'deleteAll']);
        Route::post('review', [\App\Http\Controllers\API\ReviewController::class, 'store']);
        Route::put('review/{id}', [\App\Http\Controllers\API\ReviewController::class, 'update']);
        Route::delete('review/{id}', [\App\Http\Controllers\API\ReviewController::class, 'destroy']);

        // Testimonial CRUD
        Route::get('my-testimonials', [\App\Http\Controllers\API\TestimonialController::class, 'myTestimonials']);
        Route::delete('testimonials/delete-all', [\App\Http\Controllers\API\TestimonialController::class, 'deleteAll']);
        Route::post('testimonial', [\App\Http\Controllers\API\TestimonialController::class, 'store']);
        Route::put('testimonial/{id}', [\App\Http\Controllers\API\TestimonialController::class, 'update']);
        Route::delete('testimonial/{id}', [\App\Http\Controllers\API\TestimonialController::class, 'destroy']);

        // Cart (سلة التسوق)
        Route::get('cart', [\App\Http\Controllers\API\CartController::class, 'index']);
        Route::post('cart', [\App\Http\Controllers\API\CartController::class, 'store']);
        Route::put('cart/{item_id}', [\App\Http\Controllers\API\CartController::class, 'update']);
        Route::delete('cart/{item_id}', [\App\Http\Controllers\API\CartController::class, 'destroy']);
        Route::delete('cart', [\App\Http\Controllers\API\CartController::class, 'clear']);

        // Orders (الطلبات)
        Route::get('orders', [\App\Http\Controllers\API\OrderController::class, 'index']);
        Route::get('order/{id}', [\App\Http\Controllers\API\OrderController::class, 'show']);
        Route::post('order', [\App\Http\Controllers\API\OrderController::class, 'store']);
        Route::put('order/{id}', [\App\Http\Controllers\API\OrderController::class, 'update']);
        Route::put('order/{id}/cancel', [\App\Http\Controllers\API\OrderController::class, 'cancel']);
    });
});
