<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Routing\Router;

class CheckAccountActive
{

    // Router instance
    protected $router;

    /**
     * Create a new middleware instance.
     *
     * @param  \Illuminate\Routing\Router  $router
     */
    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Get current route
        $route = $this->router->current();
        // Get the middleware list of the current route
        $middlewares = $route->gatherMiddleware();
        // Check if the current middleware list contains the 'auth' middleware
        if (in_array('auth', $middlewares)) {
            // Check if the user is not active
            if (!auth()->user()->is_active) {
                abort(403, 'Your account is not active.');
            }
        }
        return $next($request);
    }
}
