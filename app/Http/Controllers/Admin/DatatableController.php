<?php

namespace App\Http\Controllers\Admin;

use App\Models\LoginSessions;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Exceptions\Exception;

class DatatableController extends Controller
{
    /**
     * @throws Exception
     * @throws \Exception
     */
    public function roles(Request $request)
    {
        try {
            $roles = Role::all();
            return datatables()
                ->of($roles)
                ->editColumn('is_default', function ($role) {
                    return $role->is_default ? 'Yes' : 'No';
                })
                ->editColumn('updated_at', function ($role) {
                    return $role->updated_at->format('Y-m-d H:i:s');
                })
                ->addColumn('checkbox', function ($role) {
                    return '<div class="form-check form-check-sm form-check-custom form-check-solid">
                    <input class="form-check-input" type="checkbox" value="' . $role->id . '" />
                </div>';
                })
                ->addColumn('actions', function ($role) {
                    return '<a href="#" class="btn btn-light btn-active-light-primary btn-flex btn-center btn-sm table-menu" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                            ' . __('admin.roles.actions.title') . '
							<i class="ki-duotone ki-down fs-5 ms-1"></i>
                        </a>
						<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
							<div class="menu-item px-3">
								<a href="' . route('admin.roles.edit', $role->id) . '" class="menu-link px-3">
                                    ' . __('admin.roles.actions.edit') . '
                                </a>
							</div>
							<div class="menu-item px-3">
								<a href="#" class="menu-link px-3" data-kt-users-table-filter="delete_row" data-id="' . $role->id . '">
                                    ' . __('admin.roles.actions.delete') . '
                                </a>
							</div>
						</div>';
                })
                ->rawColumns(['is_default', 'updated_at', 'checkbox', 'actions'])
                ->make(true);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => $th->getMessage(),
                'draw' => 1,
                'recordsTotal' => 0,
                'recordsFiltered' => 0,
                'data' => []
            ], 200);
        }
    }

    /**
     * Get data for users table.
     * @throws Exception
     * @throws \Exception
     */
    public function users(Request $request)
    {
        try {
            $users = User::all();
            return datatables()
                ->of($users)
                ->editColumn('username', function ($user) {
                    return '<div class="d-flex align-items-center">
							<div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
								<a href="' . route('admin.users.show', $user->id) . '">
									<div class="symbol-label">
										<img src="' . $user->avatar . '" alt="Emma Smith" class="w-100">
									</div>
								</a>
							</div>
							<div class="d-flex flex-column">
								<a href="' . route('admin.users.show', $user->id) . '"
								   class="text-gray-800 text-hover-primary mb-1">
                                    ' . $user->username . '
								</a>
								<span>' . $user->email . '</span>
							</div>
						</div>';
                })
                ->editColumn('is_active', function ($user) {
                    return $user->is_active
                        ? '<span class="badge badge-light-success">'. __('admin.users.actions.yes') .'</span>'
                        : '<span class="badge badge-light-danger">'. __('admin.users.actions.no') .'</span>';
                })
                ->editColumn('last_login_at', function ($user) {
                    return $user->last_login_at ? $user->last_login_at->diffForHumans() : 'N/A';
                })
                ->editColumn('created_at', function ($user) {
                    return $user->created_at->format('Y-m-d H:i:s');
                })
                ->addColumn('checkbox', function ($user) {
                    return '<div class="form-check form-check-sm form-check-custom form-check-solid">
                    <input class="form-check-input" type="checkbox" value="' . $user->id . '" />
                </div>';
                })
                ->addColumn('roles', function ($user) {
                    $roles = $user->roles;
                    $result = '';
                    if ($roles) {
                        foreach ($roles as $role) {
                            $result .= '<span class="badge badge-light-primary">' . $role->name . '</span>';
                        }
                    } else {
                        $result = 'N/A';
                    }
                    return $result;
                })
                ->addColumn('actions', function ($user) {
                    return '<a href="#" class="btn btn-light btn-active-light-primary btn-flex btn-center btn-sm table-menu" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                            ' . __('admin.users.actions.title') . '
                            <i class="ki-duotone ki-down fs-5 ms-1"></i>
                        </a>
                        <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
                            <div class="menu-item px-3">
                                <a href="' . route('admin.users.show', $user->id) . '" class="menu-link px-3">
                                    ' . __('admin.users.actions.edit') . '
                                </a>
                            </div>
                            <div class="menu-item px-3">
                                <a href="#" class="menu-link px-3" data-kt-users-table-filter="block_row" data-id="' . $user->id . '">
                                    ' . __('admin.users.actions.block') . '
                                </a>
                            </div>
                            <div class="menu-item px-3">
                                <a href="#" class="menu-link px-3" data-kt-users-table-filter="delete_row" data-id="' . $user->id . '">
                                    ' . __('admin.users.actions.delete') . '
                                </a>
                            </div>
                        </div>';
                })
                ->rawColumns(['username', 'is_active', 'last_login_at', 'checkbox', 'roles', 'actions'])
                ->make(true);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => $th->getMessage(),
                'draw' => 1,
                'recordsTotal' => 0,
                'recordsFiltered' => 0,
                'data' => []
            ], 200);
        }
    }

    /**
     * @throws Exception
     * @throws \Exception
     */
    public function userSessions(Request $request, string $id)
    {
        $user = User::find($id);
        $session = LoginSessions::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();
        return datatables()
            ->of($session)
            ->addIndexColumn()
            ->addColumn('actions', function ($session) {
                return '<a href="javascript:void(0)" class="btn btn-light btn-active-light-primary btn-flex btn-center btn-sm"
                    onclick="checkLocation('. $session->id .')">'
                    . __('admin.users.actions.check_location')
                    . '</a>';
            })
            ->editColumn('updated_at', function ($session) {
                return $session->updated_at->format('Y-m-d H:i:s');
            })
            ->editColumn('status', function ($session) {
                $status = __('admin.users.actions.' . $session->status);
                $currentStatus = session()->get('current_session');
                if ($session->id == $currentStatus->id) {
                    $status = __('admin.users.actions.current_session');
                }
                return $status;
            })
            ->rawColumns(['actions'])
            ->make(true);
    }
}
