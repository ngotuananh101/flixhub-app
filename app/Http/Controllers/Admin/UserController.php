<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.admin.users.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
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
                default => abort(404),
            };
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
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
}
