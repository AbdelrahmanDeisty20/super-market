<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = [
        'name', // اسم الشخص المرسل للرسالة
        'phone', // رقم هاتف التواصل
        'message', // نص الرسالة المرسلة
    ]; // الحقول القابلة للتعبئة
}
