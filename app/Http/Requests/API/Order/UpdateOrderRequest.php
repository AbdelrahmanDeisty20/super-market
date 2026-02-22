<?php

namespace App\Http\Requests\API\Order;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOrderRequest extends FormRequest
{
    /**
     * تحديد صلاحية المستخدم لتنفيذ هذا الطلب
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * قواعد التحقق من صحة البيانات
     */
    public function rules(): array
    {
        return [
            'address_id' => 'nullable|exists:user_addresses,id', // معرف العنوان (اختياري)
            'delivery_date' => 'nullable|date|after_or_equal:today', // تاريخ التوصيل (اختياري)
            'delivery_time' => 'nullable|date_format:H:i', // وقت التوصيل (اختياري)
        ];
    }
}
