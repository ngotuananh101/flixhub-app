<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Exceptions\Exception;

class DatatableController extends Controller
{
    /**
     * @throws Exception
     * @throws \Exception
     */
    public function roles(Request $request)
    {
        $roles = Role::all();
        return datatables()
            ->of($roles)
            ->editColumn('is_default', function ($role) {
                return $role->is_default ? 'Yes' : 'No';
            })
            ->editColumn('updated_at', function ($role) {
                return $role->updated_at->diffForHumans();
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
    }
}
