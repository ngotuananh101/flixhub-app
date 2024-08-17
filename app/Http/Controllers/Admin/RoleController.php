<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index()
    {
        return view('pages.admin.roles.index');
    }

    public function destroy(Request $request)
    {
        try {
            $ids = $request->ids;
            $errors = [];
            foreach ($ids as $id) {
                $role = Role::find($id);
                if ($role->can_not_delete == 0 && $role->is_default == 0) {
                    // log activity
                    activity()
                        ->causedBy(auth()->user())
                        ->performedOn($role)
                        ->event('deleted')
                        ->withProperties($role->getAttributes())
                        ->log('Role deleted');
                    $role->delete();
                } else {
                    $errors[] = $role->name;
                }
            }
            if (count($errors) > 0) {
                return response()->json([
                    'success' => false,
                    'message' => __('admin.roles.actions.delete_error', ['names' => implode(', ', $errors)])
                ], 500);
            }
            return response()->json([
                'success' => true,
                'message' => __('admin.roles.actions.delete_success')
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function edit($id)
    {
        $role = Role::find($id);
        $permissions = $this->getPermissionsForJsTree($role);
        return view('pages.admin.roles.edit', [
            'role' => $role,
            'permissions' => $permissions
        ]);
    }

    public function getPermissionsForJsTree(Role $role = null){
        $permissionsAll = Permission::all();
        // Tạo mảng lưu các nhóm quyền
        $groupedPermissions = [];
        foreach ($permissionsAll as $permission) {
            $explored = explode('.', $permission->name);
            $groupName = $explored[0];
            $groupName2 = $explored[1];
            $groupName3 = $explored[2] ?? null;

            // Xây dựng cấu trúc cây quyền
            if (!isset($groupedPermissions[$groupName])) {
                $groupedPermissions[$groupName] = [
                    'text' => $groupName,
                    'children' => [],
                    'icon' => 'ki-solid ki-folder text-success'
                ];
            }
            if ($groupName3) {
                if (!isset($groupedPermissions[$groupName]['children'][$groupName2])) {
                    $groupedPermissions[$groupName]['children'][$groupName2] = [
                        'text' => $groupName2,
                        'children' => [],
                        'icon' => 'ki-solid ki-folder text-warning'
                    ];
                }
                $groupedPermissions[$groupName]['children'][$groupName2]['children'][] = [
                    'text' => $groupName3,
                    'id' => $permission->name,
                    'state' => ['selected' => $role?->hasPermissionTo($permission->name)],
                    'icon' => 'ki-solid ki-folder text-danger'
                ];
            } else {
                $groupedPermissions[$groupName]['children'][] = [
                    'text' => $groupName2,
                    'id' => $permission->name,
                    'state' => ['selected' => $role?->hasPermissionTo($permission->name)],
                    'icon' => 'ki-solid ki-folder text-warning'
                ];
            }
        }
        return array_values(array_map(function ($group) {
            $group['children'] = array_values(array_map(function ($subGroup) {
                if (isset($subGroup['children'])) {
                    $subGroup['children'] = array_values($subGroup['children']);
                }
                return $subGroup;
            }, $group['children']));
            return $group;
        }, $groupedPermissions));
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'name' => 'required|string|unique:roles,name,' . $id,
                'guard_name' => 'required|string',
                'is_default' => 'nullable|boolean',
                'permissions' => 'nullable|string',
            ]);
            $role = Role::findOrFail($id);
            $role->name = $request->name;
            $role->guard_name = $request->guard_name;
            if ($request->has('is_default') && $request->is_default) {
                $role->is_default = 1;
                // Get other default role
                $defaultRole = Role::where('is_default', 1)->where('id', '!=', $role->id)->first();
                if ($defaultRole) {
                    $defaultRole->is_default = 0;
                    $defaultRole->save();
                }
            } else {
                // Check if current role is default role
                if ($role->is_default) {
                    throw new \Exception(__('admin.roles.actions.default_role_cannot_change'));
                } else {
                    $role->is_default = 0;
                }
            }
            $permissionList = explode(',', $request->permissions ?? '');
            $permissions = [];
            foreach ($permissionList as $permission) {
                // Check if permission exists
                $permission = Permission::where('name', $permission)->first();
                if ($permission) {
                    $permissions[] = $permission;
                }
            }
            $role->syncPermissions($permissions);
            $role->updated_at = now();
            $role->save();
            // log activity
            activity()
                ->causedBy(auth()->user())
                ->performedOn($role)
                ->event('updated')
                ->withProperties($role->getAttributes())
                ->log('Role updated');
            return redirect()->route('admin.roles.index')->with('success', __('admin.roles.actions.edit_success', ['name' => $role->name]));
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }

    public function create()
    {
        return view('pages.admin.roles.create', [
            'permissions' => $this->getPermissionsForJsTree(null)
        ]);
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|unique:roles',
                'guard_name' => 'required|string',
                'is_default' => 'nullable|boolean',
                'permissions' => 'nullable|string',
            ]);
            $role = Role::create([
                'name' => $request->name,
                'guard_name' => $request->guard_name,
                'is_default' => $request->has('is_default') && $request->is_default ? 1 : 0
            ]);

            if ($request->has('is_default') && $request->is_default) {
                // Get other default role
                $defaultRole = Role::where('is_default', 1)->where('id', '!=', $role->id)->first();
                if ($defaultRole) {
                    $defaultRole->is_default = 0;
                    $defaultRole->save();
                }
            }

            $permissionList = explode(',', $request->permissions ?? '');
            $permissions = [];
            foreach ($permissionList as $permission) {
                // Check if permission exists
                $permission = Permission::where('name', $permission)->first();
                if ($permission) {
                    $permissions[] = $permission;
                }
            }
            $role->syncPermissions($permissions);
            // log activity
            activity()
                ->causedBy(auth()->user())
                ->performedOn($role)
                ->event('created')
                ->withProperties($role->getAttributes())
                ->log('Role created');
            return redirect()->route('admin.roles.index')->with('success', __('admin.roles.actions.create_success', ['name' => $role->name]));
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }
}
