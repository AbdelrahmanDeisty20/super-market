<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Coupon extends Model
{
    use HasFactory;
    protected $fillable = [
        'code', // كود الخصم (مثل: SAVE10)
        'type', // نوع الخصم (مبلغ ثابت أو نسبة مئوية)
        'value', // قيمة الخصم
        'min_order_value', // الحد الأدنى للطلب لتفعيل الكود
        'start_date', // تاريخ بداية صلاحية الكود
        'end_date', // تاريخ انتهاء صلاحية الكود
        'usage_limit', // أقصى عدد مرات استخدام للكود
        'used_count', // عدد المرات التي استُخدم فيها الكود فعلياً
        'is_active', // هل الكود مفعل حالياً؟
    ]; // الحقول القابلة للتعبئة
}
