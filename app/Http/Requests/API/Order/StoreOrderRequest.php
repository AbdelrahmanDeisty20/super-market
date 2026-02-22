<?php

namespace App\Http\Requests\API\Order;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'address_id' => 'required|exists:user_addresses,id',
            'delivery_date' => 'required|date|after_or_equal:today',
            'delivery_time' => 'required|date_format:H:i',
            'coupon_code' => 'sometimes|nullable|string|exists:coupons,code',
        ];
    }
}
