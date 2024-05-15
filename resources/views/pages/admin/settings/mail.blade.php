@extends('layouts.admin')

@section('title', __('admin.settings.mail.title'))

@section('styles')
@endsection

@section('content')
    <div class="d-flex flex-column flex-column-fluid">
        <!--begin::Toolbar-->
        <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
            <!--begin::Toolbar container-->
            <div id="kt_app_toolbar_container"
                 class="app-container container-fluid d-flex flex-stack">
                <!--begin::Page title-->
                <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                    <!--begin::Title-->
                    <h1
                        class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
                        {{ __('admin.settings.mail.title') }}
                    </h1>
                    <p class="fw-bold fs-7 text-gray-400">{{ __('admin.settings.mail.description') }}</p>
                    <!--end::Title-->
                </div>
                <!--end::Page title-->
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
                        <form action="{{ route('admin.settings.update', 'mail') }}"
                              method="POST"
                              enctype="multipart/form-data"
                              class="row">
                            @csrf
                            @method('PUT')
                            <div class="col-12 col-md-6 mb-10">
                                <label for="cache_provider" class="form-label">
                                    {{ __('admin.settings.mail.host') }}
                                </label>
                                <input type="text" class="form-control" id="mail_host"
                                       name="mail_host"
                                       value="{{ config('settings.mail_host') }}">
                                <p class="text-muted mt-2">
                                    {{ __('admin.settings.mail.host_help') }}
                                </p>
                                @error('mail_host')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-12 col-md-6 mb-10">
                                <label for="mail_port" class="form-label">
                                    {{ __('admin.settings.mail.port') }}
                                </label>
                                <input type="text" class="form-control" id="mail_port"
                                       name="mail_port"
                                       value="{{ config('settings.mail_port') }}">
                                <p class="text-muted mt-2">
                                    {{ __('admin.settings.mail.port_help') }}
                                </p>
                                @error('mail_port')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-12 col-md-6 mb-10">
                                <label for="mail_username" class="form-label">
                                    {{ __('admin.settings.mail.username') }}
                                </label>
                                <input type="text" class="form-control" id="mail_username"
                                       name="mail_username"
                                       value="{{ config('settings.mail_username') }}">
                                <p class="text-muted mt-2">
                                    {{ __('admin.settings.mail.username_help') }}
                                </p>
                                @error('mail_username')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-12 col-md-6 mb-10">
                                <label for="mail_password" class="form-label">
                                    {{ __('admin.settings.mail.password') }}
                                </label>
                                <input type="password" class="form-control" id="mail_password"
                                       name="mail_password"
                                       value="{{ config('settings.mail_password') }}">
                                <p class="text-muted mt-2">
                                    {{ __('admin.settings.mail.password_help') }}
                                </p>
                                @error('mail_password')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-12 col-md-6 mb-10">
                                <label for="mail_encryption" class="form-label">
                                    {{ __('admin.settings.mail.encryption') }}
                                </label>
                                <select class="form-select" id="mail_encryption" name="mail_encryption">
                                    <option value="ssl" {{ config('settings.mail_encryption') === 'ssl' ? 'selected' : '' }}>
                                        SSL
                                    </option>
                                    <option value="tls" {{ config('settings.mail_encryption') === 'tls' ? 'selected' : '' }}>
                                        TLS
                                    </option>
                                    <option value="null" {{ config('settings.mail_encryption') === 'null' ? 'selected' : '' }}>
                                        None
                                    </option>
                                </select>
                                <p class="text-muted mt-2">
                                    {{ __('admin.settings.mail.encryption_help') }}
                                </p>
                                @error('mail_encryption')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-12 col-md-6 mb-10">
                                <label for="mail_from_address" class="form-label">
                                    {{ __('admin.settings.mail.from_address') }}
                                </label>
                                <input type="text" class="form-control" id="mail_from_address"
                                       name="mail_from_address"
                                       value="{{ config('settings.mail_from_address') }}">
                                <p class="text-muted mt-2">
                                    {{ __('admin.settings.mail.from_address_help') }}
                                </p>
                                @error('mail_from_address')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-12 col-md-6 mb-10">
                                <label for="mail_from_name" class="form-label mb-2">
                                    {{ __('admin.settings.mail.from_name') }}
                                </label>
                                <input type="text" class="form-control" id="mail_from_name"
                                       name="mail_from_name"
                                       value="{{ config('settings.mail_from_name') }}">
                                <p class="text-muted mt-2">
                                    {{ __('admin.settings.mail.from_name_help') }}
                                </p>
                                @error('mail_from_name')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('admin.settings.mail.save') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!--end::Content container-->
        </div>
        <!--end::Content-->
    </div>
@endsection

@section('scripts')
@endsection
