<?php

namespace App\Service;

use App\Models\Review;
use App\Models\User;

class ReviewService
{
    public function getProductReviews($productId)
    {
        return Review::with('user')->where('product_id', $productId)->latest()->paginate(3);
    }

    public function getUserReviews(User $user)
    {
        return Review::with('product.images')->where('user_id', $user->id)->latest()->paginate(3);
    }

    public function storeReview(User $user, array $data)
    {
        $review = Review::create([
            'user_id' => $user->id,
            'product_id' => $data['product_id'],
            'rating' => $data['rating'],
            'comment' => $data['comment'] ?? null,
        ]);

        return $review->load('product.images');
    }

    public function updateReview(Review $review, array $data)
    {
        $review->update([
            'rating' => $data['rating'] ?? $review->rating,
            'comment' => $data['comment'] ?? $review->comment,
        ]);
        return $review->load('product.images');
    }

    public function deleteReview(Review $review)
    {
        return $review->delete();
    }

    public function deleteAllReviews(User $user)
    {
        return Review::where('user_id', $user->id)->delete();
    }
}
