<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Http\Resources\API\PageResource;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;

class PageController extends Controller
{
    use ApiResponse;

    /**
     * Display the specified page.
     *
     * @param string $slug
     * @return JsonResponse
     */

    public function index()
    {
        $pages=Page::all();
        if ($pages->isEmpty()) {
            return $this->error(__('messages.No pages found'), 404);
        }
        return $this->success(PageResource::collection($pages), __('messages.Pages fetched successfully'));
        
    }
    public function show($slug): JsonResponse
    {
        $page = Page::where('slug', $slug)->first();

        if (!$page) {
            return $this->error(__('messages.Page not found'), 404);
        }

        return $this->success(new PageResource($page), __('messages.Page fetched successfully'));
    }
}