@extends('layouts.admin')

@section('title', __('admin.users.title'))

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css') }}">
@endpush

@section('content')
    <div class="d-flex flex-column flex-column-fluid">
        <!--begin::Toolbar-->
        <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
            <!--begin::Toolbar container-->
            <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
                <!--begin::Page title-->
                <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                    <!--begin::Title-->
                    <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
                        {{ __('admin.users.title') }}
                    </h1>
                    <p class="fw-bold fs-7 text-gray-400">{{ __('admin.users.description') }}</p>
                    <!--end::Title-->
                </div>
                <!--end::Page title-->

                <!--begin::Actions-->
                <div class="d-flex align-items-center gap-2 gap-lg-3">
                    <a href="{{ route('admin.roles.create') }}"
                       class="btn btn-sm fw-bold btn-primary">
                        <i class="ki-duotone ki-plus"></i>
                        {{ __('admin.users.actions.create') }}
                    </a>
                </div>
                <!--end::Actions-->
            </div>
            <!--end::Toolbar container-->
        </div>
        <!--end::Toolbar-->
        <!--begin::Content-->
        <div id="kt_app_content" class="app-content flex-column-fluid">
            <!--begin::Content container-->
            <div id="kt_app_content_container" class="app-container container-fluid">
                <!--begin::Alert message-->
                @include('layouts.partials.alerts')
                <!--end::Alert message-->
                <div class="card card-flush mb-6 mb-xl-8 h-100">
                    <div class="card-body p-9 pt-6">
                        <!--begin::Wrapper-->
                        <div class="d-flex flex-stack mb-5">
                            <!--begin::Search-->
                            <div class="d-flex align-items-center position-relative my-1">
                                <i class="ki-duotone ki-magnifier fs-1 position-absolute ms-6">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                                <input type="text" data-kt-users-table-filter="search"
                                       class="form-control form-control-solid w-250px ps-15"
                                       placeholder="{{ __('admin.users.actions.search') }}">
                            </div>
                            <!--end::Search-->

                            <!--begin::Toolbar-->
                            <div class="d-flex justify-content-end" data-kt-users-table-toolbar="base">
                                <button type="button" class="btn btn-sm fw-bold btn-primary" id="users-table_reload">
                                    <i class="ki-duotone ki-arrows-loop">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                    {{ __('admin.users.actions.reload') }}
                                </button>
                            </div>
                            <!--end::Toolbar-->

                            <!--begin::Group actions-->
                            <div class="d-flex justify-content-end align-items-center d-none"
                                 data-kt-users-table-toolbar="selected">
                                <div class="fw-bold me-5">
                                    <span class="me-2" data-kt-users-table-select="selected_count"></span>
                                    {{ __('admin.roles.actions.selected') }}
                                </div>

                                <button type="button" class="btn btn-danger"
                                        data-kt-users-table-select="delete_selected">
                                    {{ __('admin.roles.actions.delete') }}
                                </button>
                            </div>
                            <!--end::Group actions-->
                        </div>
                        <!--end::Wrapper-->
                        <table class="table align-middle table-row-dashed fs-6 gy-5" id="users-table">
                            <thead>
                            <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                                <th class="w-10px pe-2">
                                    <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                                        <input class="form-check-input" type="checkbox" data-kt-check="true"
                                               data-kt-users-table-select="select_all"
                                               data-kt-check-target="#users-table .form-check-input" value="1"/>
                                    </div>
                                </th>
                                <th>{{ __('admin.users.fields.user') }}</th>
                                <th>{{ __('admin.users.fields.roles') }}</th>
                                <th>{{ __('admin.users.fields.is_active') }}</th>
                                <th>{{ __('admin.users.fields.last_login_at') }}</th>
                                <th>{{ __('admin.users.fields.created_at') }}</th>
                                <th class="text-end">{{ __('admin.users.fields.actions') }}</th>
                            </tr>
                            </thead>
                            <tbody class="text-gray-600 fw-semibold">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!--end::Content container-->
        </div>
        <!--end::Content-->
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
    <script>
        let usersTableApi = "{{ route('admin.datatables.users') }}";
        let usersTableDeleteApi = "{{ route('admin.users.destroy', '0') }}";
    </script>
    <script src="{{ asset('assets/js/custom/admin/users/index.js') }}"></script>
@endpush
