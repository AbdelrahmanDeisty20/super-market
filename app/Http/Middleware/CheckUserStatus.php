<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Closure;

class CheckUserStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (!$user) {
            return response()->json(['message' => __('Unauthenticated')], 401);
        }

        if (!$user->is_active) {
            return response()->json(['message' => __('Your account is inactive')], 403);
        }

        if (!$user->hasVerifiedEmail()) {
            return response()->json(['message' => __('Your email address is not verified')], 403);
        }

        return $next($request);
    }
}
