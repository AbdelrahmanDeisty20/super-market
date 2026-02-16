<?php

namespace App\Http\Requests\API\Coupon;

use Illuminate\Foundation\Http\FormRequest;

class SendCouponRequest extends FormRequest
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
            'coupon_id' => 'required|exists:coupons,id',
            'segment' => 'required|in:all,new_users,inactive,custom',
            'user_ids' => 'required_if:segment,custom|array',
            'user_ids.*' => 'exists:users,id'
        ];
    }
}
