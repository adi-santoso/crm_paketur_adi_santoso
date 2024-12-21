<?php

use App\Exceptions\IncorrectCredentialException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->api(append:[
            'throttle:api',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->reportable(function (Throwable $e) {
            Log::error($e->getMessage());
        });

        $exceptions->renderable(function (IncorrectCredentialException $e, $request) {
            return response()->json(config('rc.incorrect_credential'), 401);
        });

        $exceptions->renderable(function (NotFoundHttpException $e, $request) {
            $error = str_starts_with($e->getMessage(), 'The route')
                ? config('rc.url_not_reachable')
                : config('rc.record_not_found');
            return response()->json($error, 404);
        });

        $exceptions->renderable(function (HttpException $e) {
            return match ($e->getStatusCode()) {
                401 => response()->json(config('rc.unauthenticated'), 401),
                403 => response()->json(config('rc.forbidden'), 403),
                404 => response()->json(config('rc.record_not_found'), 404),
                405 => response()->json(config('rc.method_not_allowed'), 405),
                default => response()->json(config('rc.internal_server_error'), 500)
            };
        });

        $exceptions->renderable(function (Exception $e, $request) {
//            return response()->json(config('rc.internal_server_error'), 500);
            return response()->json($e->getMessage(), 500);
        });
    })->create();
