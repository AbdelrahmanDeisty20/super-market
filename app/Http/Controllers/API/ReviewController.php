<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\ReviewRequest;
use App\Http\Requests\UpdateReviewRequest;
use App\Http\Resources\API\ReviewResource;
use App\Models\Review;
use App\Service\ReviewService;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    use ApiResponse;

    protected $reviewService;

    public function __construct(ReviewService $reviewService)
    {
        $this->reviewService = $reviewService;
    }

    public function index($productId): JsonResponse
    {
        $reviews = $this->reviewService->getProductReviews($productId);
        $message = $reviews->isEmpty() ? __('messages.No reviews found yet') : __('messages.Reviews fetched successfully');
        return $this->paginated(ReviewResource::class, $reviews, $message);
    }

    public function myReviews(Request $request): JsonResponse
    {
        $reviews = $this->reviewService->getUserReviews($request->user());
        $message = $reviews->isEmpty() ? __('messages.No reviews found yet') : __('messages.Reviews fetched successfully');
        return $this->paginated(ReviewResource::class, $reviews, $message);
    }

    public function store(ReviewRequest $request): JsonResponse
    {
        $review = $this->reviewService->storeReview($request->user(), $request->validated());
        return $this->success(new ReviewResource($review), __('messages.Review stored successfully'), 201);
    }

    public function update(UpdateReviewRequest $request, $id): JsonResponse
    {
        $review = Review::findOrFail($id);

        if ($review->user_id !== $request->user()->id) {
            return $this->error(__('messages.Unauthorized'), 403);
        }

        $review = $this->reviewService->updateReview($review, $request->validated());
        return $this->success(new ReviewResource($review), \__('messages.Review updated successfully'));
    }

    public function destroy($id): JsonResponse
    {
        $review = Review::where('user_id', \auth()->id())->findOrFail($id);
        $this->reviewService->deleteReview($review);
        return $this->success([], \__('messages.Review deleted successfully'));
    }

    public function deleteAll(Request $request): JsonResponse
    {
        $this->reviewService->deleteAllReviews($request->user());
        return $this->success([], \__('messages.All reviews deleted successfully'));
    }
}
