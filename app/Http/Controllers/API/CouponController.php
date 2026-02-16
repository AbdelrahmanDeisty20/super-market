<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\CouponResource;
use App\Http\Requests\API\Coupon\CheckCouponRequest;
use App\Service\CouponService;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;

class CouponController extends Controller
{
    use ApiResponse;

    protected $couponService;

    public function __construct(CouponService $couponService)
    {
        $this->couponService = $couponService;
    }

    /**
     * Display a listing of active coupons.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $result = $this->couponService->getCoupons();

        if (!$result['status']) {
            return $this->error($result['message'], 404);
        }

        return $this->paginated(CouponResource::class, $result['data']);
    }

    /**
     * Check if a coupon is valid.
     *
     * @param CheckCouponRequest $request
     * @return JsonResponse
     */
    public function check(CheckCouponRequest $request): JsonResponse
    {
        $result = $this->couponService->checkCoupon($request->code, $request->order_value ?? 0);

        if (!$result['status']) {
            return $this->error($result['message'], 422, $result['data']);
        }

        return $this->success($result['data'], $result['message']);
    }
}