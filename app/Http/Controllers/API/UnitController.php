<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\UnitResource;
use App\Service\UnitService;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;

class UnitController extends Controller
{
    use ApiResponse;

    protected $unitService;

    public function __construct(UnitService $unitService)
    {
        $this->unitService = $unitService;
    }

    /**
     * Display a listing of measurement units.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $units = $this->unitService->getUnits();
        $message = $units->isEmpty() ? __('messages.No units found yet') : __('messages.Units fetched successfully');
        return $this->success(UnitResource::collection($units), $message);
    }
}
