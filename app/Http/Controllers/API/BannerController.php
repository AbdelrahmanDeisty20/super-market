<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\BannerResource;
use App\Service\BannerService;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;

class BannerController extends Controller
{
    use ApiResponse;

    protected $bannerService;

    public function __construct(BannerService $bannerService)
    {
        $this->bannerService = $bannerService;
    }

    public function index(): JsonResponse
    {
        $banners = $this->bannerService->getActiveBanners();
        $message = $banners->isEmpty() ? __('messages.No banners found yet') : __('messages.Banners fetched successfully');
        return $this->success(BannerResource::collection($banners), $message);
    }
}
