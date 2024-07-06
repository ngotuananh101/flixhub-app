<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class PermissionMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->user()->can($request->route()->getName()) && !auth()->user()->hasRole('super-admin')) {
            abort(403);
        }
        return $next($request);
    }
}
