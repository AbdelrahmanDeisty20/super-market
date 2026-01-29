<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\LoginRequest;
use App\Http\Requests\API\ProfileRequest;
use App\Http\Requests\API\RegisterRequest;
use App\Http\Requests\API\ResendEmail;
use App\Services\AuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function register(RegisterRequest $request)
    {
        return $this->authService->register($request->validated());
    }

    public function verify(Request $request)
    {
        return $this->authService->verify($request);
    }

    public function resend(ResendEmail $request)
    {
        return $this->authService->resendEmail($request->validated());
    }

    public function login(LoginRequest $request)
    {
        return $this->authService->login($request->validated());
    }

    public function logout(Request $request)
    {
        return $this->authService->logout($request);
    }

    public function profile(ProfileRequest $request)
    {
        return $this->authService->profile($request->validated());
    }
}
