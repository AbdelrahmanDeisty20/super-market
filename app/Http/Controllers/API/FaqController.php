<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\FaqResource;
use App\Service\FaqService;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;

class FaqController extends Controller
{
    use ApiResponse;

    protected $faqService;

    public function __construct(FaqService $faqService)
    {
        $this->faqService = $faqService;
    }

    public function index(): JsonResponse
    {
        $faqs = $this->faqService->getAllFaqs();
        $message = $faqs->isEmpty() ? __('messages.No FAQs found yet') : __('messages.FAQs fetched successfully');
        return $this->success(FaqResource::collection($faqs), $message);
    }
}
