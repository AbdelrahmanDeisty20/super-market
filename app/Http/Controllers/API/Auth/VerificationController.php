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
            if ($request->wantsJson()) {
                return $this->success(new UserResource($user), __('messages.Email already verified'));
            }
            return redirect(config('app.frontend_url') . '/signin?already_verified=1');
        }

        if ($user->markEmailAsVerified()) {
            event(new \Illuminate\Auth\Events\Verified($user));
        }

        if ($request->wantsJson()) {
            return $this->success(new UserResource($user), __('messages.Your email has been successfully verified'));
        }

        return redirect(env('APP_URL') . '/signin?verified=1');
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

        return $this->success(new UserResource($user), __('messages.Verification link sent'));
    }
}
