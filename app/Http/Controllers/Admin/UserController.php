<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LoginSessions;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Stevebauman\Location\Facades\Location;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $is_superadmin = auth()->user()->hasRole('super-admin');
        if ($is_superadmin) {
            $role = Role::all()->pluck('name', 'id');
        } else {
            $role = Role::where('name', '!=', 'super-admin')->get()->pluck('name', 'id');
        }
        return view('pages.admin.users.index', [
            'roles' => $role,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'avatar' => 'nullable|image|max:2048',
                'username' => 'required|string|max:255|unique:users',
                'email' => 'required|string|email|max:255|unique:users',
                'email_verified_at' => 'nullable|date',
                'password' => 'required|string|min:8|confirmed',
                'is_active' => 'nullable|boolean',
                'roles' => 'nullable|array',
            ]);
            $user = new User();
            $user->avatar = $request->file('avatar');
            $user->username = $request->input('username');
            $user->email = $request->input('email');
            $user->email_verified_at = $request->input('email_verified_at');
            $user->password = Hash::make($request->input('password'));
            $user->is_active = $request->input('is_active') ?? 0;
            $user->save();
            if ($request->has('roles')) {
                $roles = Role::whereIn('id', $request->input('roles'))->get();
                $user->syncRoles($roles);
            }
            return response()->json([
                'success' => true,
                'message' => __('admin.users.actions.create_success', ['name' => $user->username]),
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => $th->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::findOrFail($id);
        return view('pages.admin.users.show', [
            'user' => $user
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if ($id == '0') {
            $action = $request->input('action');
            return match ($action) {
                'block' => $this->block($request),
                'unblock' => $this->unblock($request),
                default => abort(404),
            };
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        try {
            $ids = $request->input('ids');
            $errors = [];

            foreach ($ids as $id) {
                $user = User::find($id);

                if ($user) {
                    // Check if the user is super admin
                    if ($user->hasRole('super-admin')) {
                        // Check if the current user is not super admin
                        if (auth()->user()->roles->first()->name !== 'super-admin') {
                            $errors[] = $id;
                            continue;
                        }

                        // Check if the user is the only super admin
                        $superAdmins = User::role('super-admin')->get();
                        if ($superAdmins->count() === 1) {
                            $errors[] = $id;
                            continue;
                        }
                    }

                    // Super admin can delete any user, including other super admins
                    // except if the current user is deleting themselves
                    if ($user->id !== auth()->user()->id) {
                        $user->delete();
                    } else {
                        $errors[] = $id;
                    }
                } else {
                    $errors[] = $id;
                }
            }

            if (count($errors) > 0) {
                return response()->json([
                    'message' => __('admin.users.actions.delete_error', ['names' => implode(',', $errors)]),
                    'errors' => $errors
                ], 500);
            }

            return response()->json([
                'message' => __('admin.users.actions.delete_success'),
                'ids' => $ids
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => __('admin.users.actions.delete_error', ['names' => 'user']),
                'error' => $th->getMessage()
            ], 500);
        }
    }


    /**
     * Block the specified resource from storage.
     */
    public function block(Request $request)
    {
        $id = $request->input('id');
        $user = User::find($id);
        $currentUserRole = auth()->user()->roles->first()->name;
        if ($user) {
            // Check if the user is super admin
            if ($user->hasRole('super-admin')) {
                // Check if the current user is not super admin
                if ($currentUserRole !== 'super-admin') {
                    return response()->json([
                        'message' => __('admin.users.actions.block_error', ['name' => $user->username]),
                        'error' => 'You do not have permission to block super admins!'
                    ], 403);
                }

                // Check if the user is the current user
                if ($user->id === auth()->user()->id) {
                    return response()->json([
                        'message' => __('admin.users.actions.block_error', ['name' => $user->username]),
                        'error' => 'You cannot block yourself!'
                    ], 403);
                }

                // Check if the user is the only super admin
                $superAdmins = User::role('super-admin')->get();
                if ($superAdmins->count() === 1) {
                    return response()->json([
                        'message' => __('admin.users.actions.block_error', ['name' => $user->username]),
                        'error' => 'You cannot block the only super admin!'
                    ], 403);
                }
            }
            $user->is_active = false;
            $user->save();
            return response()->json([
                'message' => __('admin.users.actions.block_success'),
                'user' => $user
            ]);
        } else {
            return response()->json([
                'message' => __('admin.users.actions.block_error', ['name' => $user->username]),
                'error' => 'User not found!'
            ], 500);
        }
    }

    /**
     * Check location based on IP
     */
    public function checkLocation(Request $request)
    {
        try {
            $id = $request->input('id');
            $session = LoginSessions::find($id);
            if ($session) {
                $position = Location::get($session->ip);
                if ($position) {
//                    return response()->json([
//                        'success' => true,
//                        'message' => __('admin.users.actions.check_location_success'),
//                        'position' => [
//                            'asName' => $position->asName,
//                            'cityName' => $position->cityName,
//                            'countryName' => $position->countryName,
//                            'latitude' => $position->latitude,
//                            'longitude' => $position->longitude,
//                            'map' => 'https://maps.google.com/?q=' . $position->latitude . ',' . $position->longitude
//                        ]
//                    ]);
                    $html = '<table class="table table-bordered">'
                        . '<tr>'
                        . '<td>' . __('admin.users.actions.as_name') . '</td>'
                        . '<td>' . $position->asName . '</td>'
                        . '</tr>'
                        . '<tr>'
                        . '<td>' . __('admin.users.actions.city_name') . '</td>'
                        . '<td>' . $position->cityName . '</td>'
                        . '</tr>'
                        . '<tr>'
                        . '<td>' . __('admin.users.actions.country_name') . '</td>'
                        . '<td>' . $position->countryName . '</td>'
                        . '</tr>'
                        . '<tr>'
                        . '<td>' . __('admin.users.actions.latitude') . '</td>'
                        . '<td>' . $position->latitude . '</td>'
                        . '</tr>'
                        . '<tr>'
                        . '<td>' . __('admin.users.actions.longitude') . '</td>'
                        . '<td>' . $position->longitude . '</td>'
                        . '</tr>'
                        . '<tr>'
                        . '<td>' . __('admin.users.actions.map') . '</td>'
                        . '<td><a href="https://maps.google.com/?q=' . $position->latitude . ',' . $position->longitude . '" target="_blank">' . __('admin.users.actions.view_on_map') . '</a></td>'
                        . '</tr>'
                        . '</table>';
                    return response()->json([
                        'success' => true,
                        'message' => __('admin.users.actions.check_location_success'),
                        'position' => $html
                    ]);
                }
            }
            throw new \Exception(__('admin.users.actions.check_location_error'));
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => __('admin.users.actions.check_location_error'),
                'error' => $th->getMessage()
            ], 500);
        }
    }
}
