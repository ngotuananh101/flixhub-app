<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Setting;
use Illuminate\Support\Facades\Cache;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class SettingMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        if (cache()->has('settings')) {
            $settings = Cache::get('settings');
        } else {
            $settings = Setting::all()->pluck('value', 'key');
            $settings['locales'] = json_decode($settings['locales']);
            Cache::put('settings', $settings);
        }
        config([
            'settings' => $settings,
        ]);
        return $next($request);
    }
}
