<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Route;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Make permission by route
        $routes = Route::getRoutes();
        foreach ($routes as $route) {
            // Get route name
            $routeName = $route->getName();
            // Get route middleware
            $middleware = $route->middleware()[0];
            if($routeName != '' && $middleware == 'web') {
                $permission = Permission::where('name', $routeName)->first();
                if(!$permission) {
                    Permission::create([
                        'name' => $routeName
                    ]);
                } else {
                    $permission->update([
                        'name' => $routeName,
                    ]);
                }
            }
        }
    }
}
