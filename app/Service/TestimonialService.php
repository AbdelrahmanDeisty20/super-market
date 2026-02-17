<?php

namespace App\Service;

use App\Models\Testimonial;
use App\Models\User;

class TestimonialService
{
    public function getTestimonials()
    {
        return Testimonial::with('user')->latest()->paginate(10);
    }

    public function getUserTestimonials(User $user)
    {
        return Testimonial::where('user_id', $user->id)->latest()->paginate(3);
    }

    public function storeTestimonial(User $user, array $data)
    {
        return Testimonial::create([
            'user_id' => $user->id,
            'rating' => $data['rating'],
            'comment' => $data['comment'],
        ]);
    }

    public function updateTestimonial(Testimonial $testimonial, array $data)
    {
        $testimonial->update([
            'rating' => $data['rating'] ?? $testimonial->rating,
            'comment' => $data['comment'] ?? $testimonial->comment,
        ]);

        return $testimonial;
    }

    public function deleteTestimonial(Testimonial $testimonial)
    {
        return $testimonial->delete();
    }

    public function deleteAllTestimonials(User $user)
    {
        return Testimonial::where('user_id', $user->id)->delete();
    }
}
