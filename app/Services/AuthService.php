<?php

namespace App\Services;

use App\Models\User;
use App\Http\Resources\API\UserResource;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;

class AuthService
{
    /**
     * Register a new user.
     *
     * @param array $data
     * @return array
     */
    public function register(array $data)
    {
        $user = User::create($data);

        event(new Registered($user));

        $token = $user->createToken('access_token')->plainTextToken;

        return [
            'success' => true,
            'message' => __('User registered successfully'),
            'data' => [
                'user' => new UserResource($user),
                'token' => $token,
            ]
        ];
    }

    /**
     * Login user and create token.
     *
     * @param array $data
     * @return array
     */
    public function login(array $data)
    {
        $user = User::where('email', $data['email'])->first();

        if (!$user || !Hash::check($data['password'], $user->password)) {
            return [
                'success' => false,
                'message' => __('Invalid credentials'),
            ];
        }

        // Generate Access Token
        $token = $user->createToken('access_token')->plainTextToken;

        return [
            'success' => true,
            'message' => __('Login successful'),
            'data' => [
                'user' => new UserResource($user),
                'token' => $token,
            ]
        ];
    }

    /**
     * Get the authenticated user's profile.
     *
     * @return array
     */
    public function profile()
    {
        $user = Auth::user();

        return [
            'success' => true,
            'message' => __('Profile fetched successfully'),
            'data' => new UserResource($user)
        ];
    }

    /**
     * Update the authenticated user's profile.
     *
     * @param array $data
     * @return array
     */
    public function updateProfile(array $data)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $user->update(array_filter($data));

        return [
            'success' => true,
            'message' => __('Profile updated successfully'),
            'data' => new UserResource($user)
        ];
    }

    /**
     * Logout user (Revoke token).
     *
     * @param Request $request
     * @return array
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return [
            'success' => true,
            'message' => __('Logged out successfully'),
        ];
    }
}
