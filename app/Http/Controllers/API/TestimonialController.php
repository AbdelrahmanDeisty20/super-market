<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\TestimonialResource;
use App\Http\Requests\API\TestimonialRequest;
use App\Http\Requests\UpdateTestmonialRequest;
use App\Models\Testimonial;
use App\Service\TestimonialService;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
    use ApiResponse;

    protected $testimonialService;

    public function __construct(TestimonialService $testimonialService)
    {
        $this->testimonialService = $testimonialService;
    }

    public function index(): JsonResponse
    {
        $testimonials = $this->testimonialService->getTestimonials();
        $message = $testimonials->isEmpty() ? __('messages.No testimonials found yet') : __('messages.Testimonials fetched successfully');
        return $this->paginated(TestimonialResource::class, $testimonials, $message);
    }

    public function myTestimonials(Request $request): JsonResponse
    {
        $testimonials = $this->testimonialService->getUserTestimonials($request->user());
        $message = $testimonials->isEmpty() ? __('messages.No testimonials found yet') : __('messages.Testimonials fetched successfully');
        return $this->paginated(TestimonialResource::class, $testimonials, $message);
    }

    public function store(TestimonialRequest $request): JsonResponse
    {
        $testimonial = $this->testimonialService->storeTestimonial($request->user(), $request->validated());
        return $this->success(new TestimonialResource($testimonial), __('messages.Testimonial stored successfully'), 201);
    }

    public function update(UpdateTestmonialRequest $request, $id): JsonResponse
    {
        $testimonial = Testimonial::findOrFail($id);

        if ($testimonial->user_id !== $request->user()->id) {
            return $this->error(__('messages.Unauthorized'), 403);
        }

        $testimonial = $this->testimonialService->updateTestimonial($testimonial, $request->validated());
        return $this->success(new TestimonialResource($testimonial), \__('messages.Testimonial updated successfully'));
    }

    public function destroy(int $id): JsonResponse
    {
        $testimonial = Testimonial::where('user_id', \auth()->id())->findOrFail($id);
        $this->testimonialService->deleteTestimonial($testimonial);
        return $this->success([], \__('messages.Testimonial deleted successfully'));
    }

    public function deleteAll(Request $request): JsonResponse
    {
        $this->testimonialService->deleteAllTestimonials($request->user());
        return $this->success([], \__('messages.All testimonials deleted successfully'));
    }
}
