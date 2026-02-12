<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\Auth\ResetPasswordRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use App\Traits\ApiResponse;

class ResetPasswordController extends Controller
{
    use ApiResponse;

    public function reset(ResetPasswordRequest $request)
    {
        // Enforce that the link in the email must have been clicked
        if (!Cache::has("password_reset_clicked_{$request->token}")) {
            return $this->error(__('messages.Password reset link not clicked'), 403);
        }

        $status = Password::broker()->reset(
            $request->validated(),
            function ($user, $password) {
                $user->forceFill([
                    'password' => $password // Mutator handles hashing
                ])->setRememberToken(Str::random(60));

                $user->save();
            }
        );

        return $status === Password::PASSWORD_RESET
            ? $this->success([], __('messages.Password has been reset'))
            : $this->error(__('messages.' . $status));
    }
}
