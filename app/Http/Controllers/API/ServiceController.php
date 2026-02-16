<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Http\Resources\API\ServiceResource;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;

class ServiceController extends Controller
{
    use ApiResponse;

    /**
     * Display a listing of the services.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $services = Service::all();

        if ($services->isEmpty()) {
            return $this->error(__('messages.No services found'), 404);
        }

        return $this->success(ServiceResource::collection($services), __('messages.Services fetched successfully'));
    }
}
