<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Service\BrandService;
use Illuminate\Http\Request;

use App\Traits\ApiResponse;

class BrandController extends Controller
{
    use ApiResponse;

    protected $brandService;

    public function __construct(BrandService $brandService)
    {
        $this->brandService = $brandService;
    }

    /**
     * Display a listing of brands.
     */
    public function index()
    {
        $result = $this->brandService->getBrands();

        if (!$result['success']) {
            return $this->error($result['message']);
        }

        return $this->success($result['data'], $result['message']);
    }
}
