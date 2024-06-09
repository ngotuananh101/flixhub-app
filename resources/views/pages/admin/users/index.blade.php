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
                                <input type="text" data-kt-roles-table-filter="search"
                                       class="form-control form-control-solid w-250px ps-15"
                                       placeholder="{{ __('admin.users.actions.search') }}">
                            </div>
                            <!--end::Search-->

                            <!--begin::Toolbar-->
                            <div class="d-flex justify-content-end" data-kt-roles-table-toolbar="base">
                                <button type="button" class="btn btn-sm fw-bold btn-primary" id="roles-table_reload">
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
                                 data-kt-roles-table-toolbar="selected">
                                <div class="fw-bold me-5">
                                    <span class="me-2" data-kt-roles-table-select="selected_count"></span>
                                    {{ __('admin.roles.actions.selected') }}
                                </div>

                                <button type="button" class="btn btn-danger" data-kt-roles-table-select="delete_selected">
                                    {{ __('admin.roles.actions.delete') }}
                                </button>
                            </div>
                            <!--end::Group actions-->
                        </div>
                        <!--end::Wrapper-->
                        <table class="table align-middle table-row-dashed fs-6 gy-5" id="roles-table">
                            <thead>
                            <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase">
                                <th class="w-10px pe-2">
                                    <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                                        <input class="form-check-input"
                                               type="checkbox"
                                               data-kt-check="true"
                                               data-kt-check-target="#roles-table .form-check-input"
                                               value="0"
                                               data-kt-roles-table-select="select_all"
                                        />
                                    </div>
                                </th>
                                <th>{{ __('admin.roles.columns.name') }}</th>
                                <th>{{ __('admin.roles.columns.guard_name') }}</th>
                                <th>{{ __('admin.roles.columns.is_default') }}</th>
                                <th>{{ __('admin.roles.columns.last_updated') }}</th>
                                <th class="text-end">{{ __('admin.roles.columns.actions') }}</th>
                            </tr>
                            </thead>
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
        let csrfToken = "{{ csrf_token() }}";
        let rolesTableApi = "{{ route('admin.datatables.roles') }}";
        let rolesTableDeleteApi = "{{ route('admin.roles.destroy', '0') }}";
    </script>
    <script src="{{ asset('assets/js/custom/admin/roles/index.js') }}"></script>
@endpush
