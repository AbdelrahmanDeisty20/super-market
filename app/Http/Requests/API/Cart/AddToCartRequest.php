<?php

namespace App\Http\Requests\API\Cart;

use Illuminate\Foundation\Http\FormRequest;

class AddToCartRequest extends FormRequest
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
            'product_id' => 'required|exists:products,id', // معرف المنتج المطلوب
            'quantity' => 'required|integer|min:1', // الكمية المطلوبة
        ];
    }
}
