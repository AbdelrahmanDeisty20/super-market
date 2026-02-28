<?php

namespace App\Models;

use App\Models\AppNotification;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail, FilamentUser
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',  // اسم المستخدم الكامل
        'email',  // البريد الإلكتروني (فريد)
        'phone',  // رقم الهاتف للتواصل/التوصيل
        'password',  // كلمة المرور المشفرة
        'image',  // مسار صورة الملف الشخصي
        'role',  // دور المستخدم (أدمن أو مستخدم عادي)
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return $this->hasRole('super_admin');
    }

    /**
     * الحصول على جميع عناوين المستخدم
     */
    public function addresses()
    {
        return $this->hasMany(UserAddress::class);  // علاقة واحد لمتعدد مع العناوين
    }

    /**
     * الحصول على جميع طلبات المستخدم
     */
    public function orders()
    {
        return $this->hasMany(Order::class);  // علاقة واحد لمتعدد مع الطلبات
    }

    /**
     * الحصول على سلة التسوق الخاصة بالمستخدم
     */
    public function cart()
    {
        return $this->hasOne(Cart::class);  // علاقة واحد لواحد مع السلة
    }

    /**
     * الحصول على جميع تقييمات المنتج التي قام بها المستخدم
     */
    public function reviews()
    {
        return $this->hasMany(Review::class);  // علاقة واحد لمتعدد مع التقييمات
    }

    /**
     * الحصول على قائمة المنتجات المفضلة للمستخدم
     */
    public function wishlists()
    {
        return $this->hasMany(Whishlist::class);  // علاقة واحد لمتعدد مع المفضلات
    }

    public function appNotifications()
    {
        return $this->hasMany(AppNotification::class);  // علاقة واحد لمتعدد مع الإشعارات الخاصة بالتطبيق
    }

    /**
     * الحصول على جميع رموز أجهزة المستخدم (FCM Tokens)
     */
    public function fcmTokens()
    {
        return $this->hasMany(UserFcmToken::class);
    }

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new \App\Notifications\ResetPassword($token));
    }

    /**
     * Send the email verification notification.
     *
     * @return void
     */
    public function sendEmailVerificationNotification()
    {
        $this->notify(new \App\Notifications\VerifyEmail);
    }
}
