<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Traits\ApiResponse;
use App\Http\Resources\API\UserResource;

class VerificationController extends Controller
{
    use ApiResponse;

    public function verify(Request $request, $id, $hash)
    {
        $user = User::findOrFail($id);

        if (!hash_equals((string) $hash, sha1($user->getEmailForVerification()))) {
            return $this->error(__('messages.Invalid verification link'), 403);
        }

        if ($user->hasVerifiedEmail()) {
            return view('auth.verified', [
                'title' => __('messages.Email Already Verified'),
                'message' => __('messages.Your email is already verified. You can continue using the app.')
            ]);
        }

        if ($user->markEmailAsVerified()) {
            event(new \Illuminate\Auth\Events\Verified($user));
        }

        return view('auth.verified', [
            'title' => __('messages.Email Verified!'),
            'message' => __('messages.Your email has been successfully verified.')
        ]);
    }

    public function resend(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email'
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user->hasVerifiedEmail()) {
            return $this->error(__('messages.Email already verified'), 400);
        }

        $user->sendEmailVerificationNotification();

        return $this->success([], __('messages.Verification link sent'));
    }
}
