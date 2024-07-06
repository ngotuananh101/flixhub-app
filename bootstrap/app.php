<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Sentry\Laravel\Integration;
use App\Http\Middleware\SettingMiddleware;
use Illuminate\Http\Request;
use App\Http\Middleware\PermissionMiddleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Set global middlewares
        $middleware->append([
            SettingMiddleware::class,
        ]);
        // Set alias
        $middleware->alias([
            'permission' => PermissionMiddleware::class,
        ]);
        // Redirect to login page if user is not authenticated
        $middleware->redirectGuestsTo(fn (Request $request) => route('auth.login'));
    })
    ->withExceptions(function (Exceptions $exceptions) {
        Integration::handles($exceptions);
    })->create();
