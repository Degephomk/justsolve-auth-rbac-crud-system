<?php

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

$app = Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )

    ->withMiddleware(function (Middleware $middleware) {
    // CORS for SPA
    $middleware->append(\Illuminate\Http\Middleware\HandleCors::class);

    // Sanctum for SPA tokens
    $middleware->append(\Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class);

    // ------------------------------------------------------
    //  CUSTOM ROUTE MIDDLEWARE (Laravel 11/12 way)
    // ------------------------------------------------------
    $middleware->alias([
        'isAdmin' => \App\Http\Middleware\IsAdmin::class,
    ]);
})


    // ->withExceptions(function (Exceptions $exceptions) {
    //     // ✔ Fix redirect to /login for API
    //     $exceptions->renderable(function (AuthenticationException $e, $request) {
    //         if ($request->is('api/*')) {
    //             return response()->json(['message' => 'Unauthenticated'], 401);
    //         }
    //     });
    // });
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (
            AuthenticationException $e,
            \Illuminate\Http\Request $request
        ) {
            if ($request->is('api/*')) {
                return response()->json([
                    'message' => 'Unauthenticated',
                ], 401);
            }
        });
    });
return $app->create();
