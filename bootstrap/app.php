<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        channels: __DIR__.'/../routes/channels.php',
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->api(prepend: [
            \App\Http\Middleware\setLang::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (\Illuminate\Auth\AuthenticationException $e, \Illuminate\Http\Request $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'status' => false,
                    'message' => __('messages.unauthenticated'),
                    'data' => [],
                ], 401);
            }
        });

        $exceptions->render(function (\Symfony\Component\HttpKernel\Exception\NotFoundHttpException $e, \Illuminate\Http\Request $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'status' => false,
                    'message' => __('messages.Resource not found'),
                    'data' => [],
                ], 404);
            }
        });

        $exceptions->render(function (\Illuminate\Validation\ValidationException $e, \Illuminate\Http\Request $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'status' => false,
                    'message' => $e->getMessage(),
                    'data' => $e->errors(),
                ], 422);
            }
        });

        $exceptions->render(function (\Throwable $e, \Illuminate\Http\Request $request) {
            if ($request->is('api/*')) {
                $status = 500;
                if (method_exists($e, 'getStatusCode')) {
                    $status = $e->getStatusCode();
                } elseif (property_exists($e, 'status')) {
                    $status = $e->status;
                }

                return response()->json([
                    'status' => false,
                    'message' => $e->getMessage(),
                    'error_type' => class_basename($e)
                ], $status);
            }
        });
    })->create();
