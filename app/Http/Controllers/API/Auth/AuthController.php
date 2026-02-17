<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\Auth\LoginRequest;
use App\Http\Requests\API\Auth\RegisterRequest;
use App\Http\Requests\API\Auth\UpdateProfileRequest;
use App\Service\AuthService;
use App\Traits\ApiResponse;
use App\Http\Resources\API\UserResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    use ApiResponse;

    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function register(RegisterRequest $request)
    {
        $result = $this->authService->register($request->validated());

        // Match real_estate response structure
        $data = [
            'user' => new UserResource($result['user']),
            'requires_verification' => $result['requires_verification']
        ];

        return $this->success($data, __('messages.Account registered successfully, please verify your email address'), 201);
    }

    public function login(LoginRequest $request)
    {
        $result = $this->authService->login($request->validated());

        $data = [
            'token' => $result['token'],
            'user' => new UserResource($result['user']),
        ];

        return $this->success($data, __('messages.Login successful'));
    }

    public function logout(Request $request): JsonResponse
    {
        $this->authService->logout($request->user());
        return $this->success([], __('messages.Logged out successfully'));
    }

    public function logoutAll(Request $request): JsonResponse
    {
        $this->authService->logoutAll($request->user());
        return $this->success([], __('messages.Logged out from all devices successfully'));
    }

    public function profile(Request $request)
    {
        return $this->success(new UserResource($request->user()), __('messages.Profile fetched successfully'));
    }

    public function update(UpdateProfileRequest $request)
    {
        $user = $this->authService->updateProfile($request->user(), $request->validated());
        return $this->success(new UserResource($user), __('messages.Profile updated successfully'));
    }

    public function destroy(Request $request)
    {
        $this->authService->deleteProfile($request->user());
        return $this->success([], __('messages.Account deleted successfully'));
    }
}
