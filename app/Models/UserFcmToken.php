<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserFcmToken extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'fcm_token',
        'device_id',
    ];

    /**
     * العلاقة مع المستخدم صاحب التوكن
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
