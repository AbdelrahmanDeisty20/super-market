<?php

namespace App\Services;

use App\Models\User;
use App\Notifications\VerifyEmail;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Auth;
use Hash;

class AuthService
{
    public function register(array $data)
    {
        $user = User::create($data);
        event(new Registered($user));
        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json([
            'status' => true,
            'message' => __('Register successfully'),
            'user' => $user,
            'token' => $token,
        ]);
    }

    public function verify($request)
    {
        $user = User::findOrFail($request->route('id'));

        if (!hash_equals((string) $request->route('hash'), sha1($user->getEmailForVerification()))) {
            return response()->json(['message' => __('Invalid verification link')], 403);
        }

        if ($user->hasVerifiedEmail()) {
            return view('auth.verified', [
                'title' => __('Email Already Verified'),
                'message' => __('Your email is already verified. You can continue using the app.')
            ]);
        }

        if ($user->markEmailAsVerified()) {
            event(new \Illuminate\Auth\Events\Verified($user));
        }

        return view('auth.verified');
    }

    public function resendEmail(array $data)
    {
        $user = User::where('email', $data['email'])->first();

        if ($user->hasVerifiedEmail()) {
            return response()->json(['status' => true, 'message' => __('Email already verified')]);
        }

        $user->notify(new VerifyEmail());

        return response()->json(['status' => true, 'message' => __('Verification link sent')]);
    }

    public function login(array $data)
    {
        $user = User::where('email', $data['email'])->first();

        if (!$user || !Hash::check($data['password'], $user->password)) {
            return response()->json([
                'status' => true,
                'message' => __('Invalid credentials')
            ]);
        }

        if (!$user->hasVerifiedEmail()) {
            return response()->json([
                'status' => true,
                'message' => __('Your email address is not verified')
            ]);
        }
        // Generate Access Token (with all permissions)
        $token = $user->createToken('access_token', ['*'], now()->addHours(2))->plainTextToken;

        // Generate Refresh Token (with restricted permissions, e.g., 'refresh-token')
        $refreshToken = $user->createToken('refresh_token', ['refresh-token'], now()->addDays(7))->plainTextToken;

        return response()->json([
            'status' => true,
            'message' => __('Login successfully'),
            'user' => $user,
            'token' => $token,
            'refresh_token' => $refreshToken,
        ]);
    }

    public function profile(array $data)
    {
        $user = auth()->user();
        $user->update(array_filter($data));

        return response()->json([
            'status' => true,
            'message' => __('Profile updated successfully'),
            'user' => $user,
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            'status' => true,
            'message' => __('Logout successfully')
        ]);
    }
}
