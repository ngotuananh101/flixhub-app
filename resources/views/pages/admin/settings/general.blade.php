@extends('layouts.admin')

@section('title', __('admin.settings.general.title'))

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
                        {{ __('admin.settings.general.title') }}
                    </h1>
                    <p class="fw-bold fs-7 text-gray-400">{{ __('admin.settings.general.description') }}</p>
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
                        <form action="{{ route('admin.settings.update', 'general') }}"
                              method="POST"
                              enctype="multipart/form-data"
                              class="row">
                            @csrf
                            @method('PUT')
                            <div class="col-12 col-md-6 mb-10">
                                <label for="site_url" class="form-label">
                                    {{ __('admin.settings.general.app_name') }}
                                </label>
                                <input type="text" class="form-control" id="app_name" name="app_name"
                                       value="{{ old('app_name', config('settings.app_name')) }}"/>
                                @error('app_name')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-12 col-md-6 mb-10">
                                <label for="site_url" class="form-label">
                                    {{ __('admin.settings.general.app_description') }}
                                </label>
                                <input type="text" class="form-control" id="app_description"
                                       name="app_description"
                                       value="{{ old('app_description', config('settings.app_description')) }}"/>
                                @error('app_description')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-12 col-md-6 mb-10">
                                <label for="site_url" class="form-label">
                                    {{ __('admin.settings.general.app_url') }}
                                </label>
                                <input type="text" class="form-control" id="app_url" name="app_url"
                                       value="{{ old('app_url', config('settings.app_url')) }}"/>
                                @error('app_url')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-12 col-md-6 mb-10">
                                <label for="site_url" class="form-label">
                                    {{ __('admin.settings.general.app_timezone') }}
                                </label>
                                <select class="form-select" id="app_timezone" name="app_timezone"
                                        data-control="select2">
                                    @foreach (timezone_identifiers_list() as $timezone)
                                        <option value="{{ $timezone }}"
                                            {{ old('app_timezone', config('settings.app_timezone')) == $timezone ? 'selected' : '' }}>
                                            {{ $timezone }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('app_timezone')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-12 col-md-6 mb-10">
                                <label for="site_url" class="form-label">
                                    {{ __('admin.settings.general.app_locale') }}
                                </label>
                                <select class="form-select" id="app_locale" name="app_locale"
                                        data-control="select2">
                                    @foreach (config('settings.locales') as $locale)
                                        <option value="{{ $locale }}"
                                            {{ old('app_locale', config('settings.app_locale')) == $locale ? 'selected' : '' }}>
                                            {{ $locale }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('app_locale')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-12 col-md-6 mb-10">
                                <label for="site_url" class="form-label">
                                    {{ __('admin.settings.general.app_theme') }}
                                </label>
                                <select class="form-select" id="app_theme" name="app_theme"
                                        data-control="select2">
                                    <option value="light"
                                        {{ old('app_theme', config('settings.app_theme')) == 'light' ? 'selected' : '' }}>
                                        Light
                                    </option>
                                    <option value="dark"
                                        {{ old('app_theme', config('settings.app_theme')) == 'dark' ? 'selected' : '' }}>
                                        Dark
                                    </option>
                                </select>
                                @error('app_theme')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-12 col-md-6 mb-10">
                                <label for="site_url" class="form-label">
                                    {{ __('admin.settings.general.app_favicon') }}
                                </label>
                                <input type="file" class="form-control" id="app_favicon"
                                       name="app_favicon" accept="image/png"/>
                                @error('app_favicon')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                                <div class="form-text preview-image">
                                    <img src="{{ asset(config('settings.app_favicon')) }}"
                                         class="img-thumbnail mt-2" alt="App Favicon"/>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 mb-10">
                                <label for="site_url" class="form-label">
                                    {{ __('admin.settings.general.app_logo_small') }}
                                </label>
                                <input type="file" class="form-control" id="app_logo_small"
                                       name="app_logo_small" accept="image/png"/>
                                @error('app_logo_small')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                                <div class="form-text preview-image">
                                    <img src="{{ asset(config('settings.app_logo_small')) }}"
                                         class="img-thumbnail mt-2" alt="App Logo Small"/>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 mb-10">
                                <label for="site_url" class="form-label">
                                    {{ __('admin.settings.general.app_logo') }}
                                </label>
                                <input type="file" class="form-control" id="app_logo"
                                       name="app_logo" accept="image/png"/>
                                @error('app_logo')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                                <div class="form-text preview-image">
                                    <img src="{{ asset(config('settings.app_logo')) }}"
                                         class="img-fluid img-thumbnail mt-2" alt="App Logo"/>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 mb-10">
                                <label for="site_url" class="form-label">
                                    {{ __('admin.settings.general.app_logo_dark') }}
                                </label>
                                <input type="file" class="form-control" id="app_logo_dark"
                                       name="app_logo_dark" accept="image/png"/>
                                @error('app_logo_dark')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                                <div class="form-text preview-image">
                                    <img src="{{ asset(config('settings.app_logo_dark')) }}"
                                         class="img-fluid img-thumbnail mt-2" alt="App Logo (Dark)"/>
                                </div>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('admin.settings.general.save') }}
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
