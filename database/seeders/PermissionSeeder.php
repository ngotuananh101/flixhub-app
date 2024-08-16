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
            if($routeName != '') {
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
