<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\Auth\ForgotPasswordRequest;
use Illuminate\Support\Facades\Password;
use App\Traits\ApiResponse;

class ForgotPasswordController extends Controller
{
    use ApiResponse;

    public function sendResetLinkEmail(ForgotPasswordRequest $request)
    {
        $user = \App\Models\User::where('email', $request->email)->first();

        $broker = Password::broker();

        // Check if a token was recently created to respect throttling
        if ($broker->getRepository()->recentlyCreatedToken($user)) {
            return $this->error(__('messages.throttled'), 429);
        }

        // Generate Token
        $token = $broker->createToken($user);

        // Send the notification manually to bypass the broker's second throttle check
        $user->sendPasswordResetNotification($token);

        return $this->success(['token' => $token], __('messages.Password reset link sent'));
    }
}
