<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
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
}
