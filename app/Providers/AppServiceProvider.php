<?php

namespace App\Providers;

use BezhanSalleh\LanguageSwitch\LanguageSwitch;
use Illuminate\Support\ServiceProvider;

use Illuminate\Auth\Notifications\ResetPassword;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // تسجيل مراقبين (Observers) الموديلات لمراقبة التغييرات
        \App\Models\Offer::observe(\App\Observers\OfferObserver::class);
        \App\Models\Coupon::observe(\App\Observers\CouponObserver::class);
        \App\Models\Order::observe(\App\Observers\OrderObserver::class);

        ResetPassword::createUrlUsing(function (object $notifiable, string $token) {
            return route('api.password.verify', ['token' => $token, 'email' => $notifiable->getEmailForPasswordReset()]);
        });
        LanguageSwitch::configureUsing(function (LanguageSwitch $switch) {
            $switch
                ->locales(['ar', 'en']);
        });

        app()->setLocale(session('lang', default: config('app.locale')));
    }
}
