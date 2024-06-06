@extends('layouts.admin')

@section('title', __('admin.roles.create.title'))

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/plugins/custom/jstree/jstree.bundle.css') }}">
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
                        {{ __('admin.roles.create.title') }}
                    </h1>
                    <p class="fw-bold fs-7 text-gray-400">{{ __('admin.roles.create.description') }}</p>
                    <!--end::Title-->
                </div>
                <!--end::Page title-->

                <!--begin::Actions-->
                <div class="d-flex align-items-center gap-2 gap-lg-3">
                    <a href="{{ route('admin.roles.create') }}" class="btn btn-sm fw-bold btn-primary">
                        <i class="ki-duotone ki-plus"></i>
                        {{ __('admin.roles.actions.create') }}
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
                        <form action="{{ route('admin.roles.store') }}" method="POST" class="row">
                            @csrf
                            <input type="hidden" name="permissions" id="inputPermissions">
                            <div class="col-12 mb-5 fv-row">
                                <label class="required fs-6 fw-bold mb-2">{{ __('admin.roles.fields.name') }}</label>
                                <input type="text" class="form-control form-control-solid" name="name"
                                       value="" placeholder="{{ __('admin.roles.fields.name') }}"
                                       required/>
                            </div>
                            <div class="col-12 mb-5 fv-row">
                                <label
                                    class="required fs-6 fw-bold mb-2">{{ __('admin.roles.fields.guard_name') }}</label>
                                <input type="text" class="form-control form-control-solid" name="guard_name"
                                       value=""
                                       placeholder="{{ __('admin.roles.fields.guard_name') }}" required/>
                            </div>
                            <div class="col-12 mb-5 fv-row">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="is_default" id="is_default"
                                           value="1">
                                    <label class="fw-bold" for="flexCheckDefault">
                                        Default ?
                                    </label>
                                </div>
                            </div>
                            <div class="col-12 mb-5 fv-row">
                                <label class="required fs-6 fw-bold mb-2">
                                    {{ __('admin.roles.fields.permissions') }}
                                </label>
                                <div id="permissions_of_role"></div>
                            </div>
                            <!--begin::Actions-->
                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary">
                                    <span class="indicator-label">{{ __('admin.roles.actions.save') }}</span>
                                </button>
                            </div>
                            <!--end::Actions-->
                        </form>
                    </div>
                </div>
            </div>
            <!--end::Content container-->
        </div>
        <!--end::Content-->
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('assets/plugins/custom/jstree/jstree.bundle.js') }}"></script>
    <script>
        let groupPermission = @json($permissions);
    </script>
        <script src="{{ asset('assets/js/custom/admin/roles/create.js') }}"></script>
@endpush
