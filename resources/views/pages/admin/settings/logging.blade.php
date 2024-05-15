@extends('layouts.admin')

@section('title', __('admin.settings.logging.title'))

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
                        {{ __('admin.settings.logging.title') }}
                    </h1>
                    <p class="fw-bold fs-7 text-gray-400">{{ __('admin.settings.logging.description') }}</p>
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
                        <form action="{{ route('admin.settings.update', 'logging') }}"
                              method="POST"
                              class="row">
                            @csrf
                            @method('PUT')
                            <div class="col-12 mb-10">
                                <label for="sentry_laravel_dsn" class="form-label">
                                    {{ __('admin.settings.logging.sentry_laravel_dsn') }}
                                </label>
                                <input type="text" class="form-control" id="sentry_laravel_dsn"
                                       name="sentry_laravel_dsn"
                                       value="{{ config('settings.sentry_laravel_dsn') }}">
                                <p class="text-muted mt-2">
                                    {{ __('admin.settings.logging.sentry_laravel_dsn_help')}}
                                </p>
                                @error('sentry_laravel_dsn')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-12 col-md-6 mb-10">
                                <label for="sentry_client_key" class="form-label">
                                    {{ __('admin.settings.logging.sentry_client_key') }}
                                </label>
                                <input type="text" class="form-control" id="sentry_client_key"
                                       name="sentry_client_key"
                                       value="{{ config('settings.sentry_client_key') }}">
                                <p class="text-muted mt-2">
                                    {{ __('admin.settings.logging.sentry_client_key_help') }}
                                </p>
                                @error('sentry_client_key')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-12 col-md-6 mb-10">
                                <label for="sentry_client_key" class="form-label">
                                    {{ __('admin.settings.logging.sentry_traces_sample_rate') }}
                                </label>
                                <input type="number" class="form-control" id="sentry_traces_sample_rate"
                                       name="sentry_traces_sample_rate"
                                       step="0.1"
                                       value="{{ config('settings.sentry_traces_sample_rate') }}">
                                <p class="text-muted mt-2">
                                    {{ __('admin.settings.logging.sentry_traces_sample_rate_help') }}
                                </p>
                                @error('sentry_traces_sample_rate')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-12 mb-10">
                                <div
                                    class="alert bg-light-warning border border-warning border-dashed
                                            d-flex flex-column flex-sm-row w-100 p-5 mb-10">
                                    <div class="d-flex flex-column pe-0 pe-sm-10">
                                        <h5 class="mb-1">
                                            {{ __('admin.settings.logging.note') }}:
                                        </h5>
                                        <span>
                                            {!! __('admin.settings.logging.sentry_info') !!}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="separator mb-10"></div>
                            <div class="col-12 col-md-6 mb-10">
                                <label for="log_channel" class="form-label">
                                    {{ __('admin.settings.logging.channel') }}
                                </label>
                                <select class="form-select" id="log_channel" name="log_channel"
                                        data-control="select2">
                                    @foreach($logChannels as $key => $logChannel)
                                        <option value="{{ $key }}"
                                                @if(config('settings.log_channel') === $key)
                                                    selected
                                            @endif
                                        >
                                            {{ $logChannel }}
                                        </option>
                                    @endforeach
                                </select>
                                <p class="text-muted mt-2">
                                    {{ __('admin.settings.logging.channel_help') }}
                                </p>
                                @error('log_channel')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-12 col-md-6 mb-10">
                                <label for="log_level" class="form-label">
                                    {{ __('admin.settings.logging.level') }}
                                </label>
                                <select class="form-select" id="log_level" name="log_level"
                                        data-control="select2">
                                    @foreach($logLevels as $key => $logLevel)
                                        <option value="{{ $key }}"
                                                @if(config('settings.log_level') === $key)
                                                    selected
                                            @endif
                                        >
                                            {{ $logLevel }}
                                        </option>
                                    @endforeach
                                </select>
                                <p class="text-muted mt-2">
                                    {{ __('admin.settings.logging.level_help') }}
                                </p>
                                @error('log_level')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('admin.settings.logging.save') }}
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
