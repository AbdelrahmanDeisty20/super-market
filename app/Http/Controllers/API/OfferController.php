<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\OfferResource;
use App\Service\OfferService;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;

class OfferController extends Controller
{
    use ApiResponse;

    protected $offerService;

    public function __construct(OfferService $offerService)
    {
        $this->offerService = $offerService;
    }

    /**
     * Display a listing of offers.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $result = $this->offerService->getOffers();

        if (!$result['status']) {
            return $this->error($result['message'], 404);
        }

        return $this->paginated(OfferResource::class,$result['data']);
    }

    /**
     * Display the specified offer.
     *
     * @param int|string $id
     * @return JsonResponse
     */
    public function show($id): JsonResponse
    {
        $result = $this->offerService->getOfferById($id);

        if (!$result['status']) {
            return $this->error($result['message'], 404);
        }

        return $this->success($result['data'], $result['message']);
    }
}