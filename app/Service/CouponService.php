<?php

namespace App\Service;

use App\Models\Coupon;
use App\Http\Resources\API\CouponResource;
use Carbon\Carbon;

class CouponService
{
    /**
     * Get all active and valid coupons.
     *
     * @return array
     */
    public function getCoupons()
    {
        $now = Carbon::now();
        $coupons = Coupon::where('is_active', true)
            ->where(function ($query) use ($now) {
                $query->whereNull('start_date')
                    ->orWhere('start_date', '<=', $now);
            })
            ->where(function ($query) use ($now) {
                $query->whereNull('end_date')
                    ->orWhere('end_date', '>=', $now);
            })
            ->whereColumn('used_count', '<', 'usage_limit')
            ->paginate(10);

        if ($coupons->isEmpty()) {
            return [
                'status' => false,
                'message' => __('messages.No coupons found'),
                'data' => []
            ];
        }

        return [
            'status' => true,
            'message' => __('messages.Coupons fetched successfully'),
            'data' => $coupons
        ];
    }

    /**
     * Check if a coupon is valid.
     *
     * @param string $code
     * @param float $orderValue
     * @return array
     */
    public function checkCoupon($code, $orderValue = 0)
    {
        $now = Carbon::now();
        $coupon = Coupon::where('code', $code)
            ->where('is_active', true)
            ->first();

        if (!$coupon) {
            return [
                'status' => false,
                'message' => __('messages.Invalid coupon code'),
                'data' => []
            ];
        }

        // Check date
        if (($coupon->start_date && $now->lt($coupon->start_date)) ||
            ($coupon->end_date && $now->gt($coupon->end_date))
        ) {
            return [
                'status' => false,
                'message' => __('messages.Coupon has expired'),
                'data' => []
            ];
        }

        // Check usage limit
        if ($coupon->used_count >= $coupon->usage_limit) {
            return [
                'status' => false,
                'message' => __('messages.Coupon usage limit reached'),
                'data' => []
            ];
        }

        // Check min order value
        if ($orderValue < $coupon->min_order_value) {
            return [
                'status' => false,
                'message' => __('messages.Order value is below the minimum required for this coupon'),
                'data' => ['min_order_value' => $coupon->min_order_value]
            ];
        }

        return [
            'status' => true,
            'message' => __('messages.Coupon is valid'),
            'data' => new CouponResource($coupon)
        ];
    }
}
