@extends('layouts.admin')

@section('title', __('admin.settings.cache.title'))

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
                        {{ __('admin.settings.cache.title') }}
                    </h1>
                    <p class="fw-bold fs-7 text-gray-400">{{ __('admin.settings.cache.description') }}</p>
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
                        <form action="{{ route('admin.settings.update', 'cache') }}"
                              method="POST"
                              enctype="multipart/form-data"
                              class="row">
                            @csrf
                            @method('PUT')
                            <div class="col-12">
                                <div class="mb-10">
                                    <label for="cache_provider" class="form-label">
                                        {{ __('admin.settings.cache.cache_store') }}
                                    </label>
                                    <select class="form-select" id="cache_store" name="cache_store">
                                        @foreach($cacheProviders as $key => $provider)
                                            <option value="{{ $key }}"
                                                    @if($key === config('settings.cache_store'))
                                                        selected
                                                @endif
                                            >
                                                {{ $provider }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <p class="text-muted mt-2">
                                        {{ __('admin.settings.cache.cache_store_help') }}
                                    </p>
                                    @error('cache_store')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-10">
                                    <label for="cache_provider" class="form-label">
                                        {{ __('admin.settings.cache.cache_prefix') }}
                                    </label>
                                    <input type="text" class="form-control" id="cache_prefix"
                                           name="cache_prefix"
                                           value="{{ config('settings.cache_prefix') }}">
                                    <p class="text-muted mt-2">
                                        {{ __('admin.settings.cache.cache_prefix_help') }}
                                    </p>
                                    @error('cache_prefix')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="separator my-10"></div>
                                <div class="d-flex justify-content-between">
                                    <a href="{{ route('admin.settings.clearCache') }}"
                                       class="btn btn-outline btn-outline-dashed btn-outline-warning
                                               btn-active-light-warning">
                                        Clear Cache
                                    </a>
                                </div>
                                <div
                                    class="alert bg-light-warning border border-warning border-dashed
                                            d-flex flex-column flex-sm-row w-100 p-5 my-10">
                                    <div class="d-flex flex-column pe-0 pe-sm-10">
                                        <h5 class="mb-1">
                                            {{ __('admin.settings.cache.note') }}:
                                        </h5>
                                        <span>
                                            {!! __('admin.settings.cache.cache_info') !!}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('admin.settings.cache.save') }}
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
