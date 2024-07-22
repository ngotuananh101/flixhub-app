<!DOCTYPE html>
<html lang="en">

<head>
    <base href="{{ config('settings.app_url') }}"/>
    <title>@yield('title', config('settings.app_name')) | {{ config('settings.app_name') }}</title>
    <meta charset="utf-8"/>
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <meta name="description" content="{{ config('settings.app_description') }}"/>
    <meta name="keywords" content="{{ config('settings.app_keywords') }}"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <meta property="og:locale" content="en_US"/>
    <meta property="og:type" content="article"/>
    <meta property="og:title" content="@yield('title', config('settings.app_name')) by {{ config('settings.app_name') }}"/>
    <meta property="og:url" content="{{ url()->current() }}"/>
    <meta property="og:site_name" content="{{ config('settings.app_name') }}"/>
    <link rel="canonical" href="{{ url()->current() }}"/>
    <link rel="shortcut icon" href="{{ asset(config('settings.app_favicon')) }}"/>
    @stack('styles')
    @include('layouts.partials.styles')
    @include('layouts.partials.click-jacking')
</head>
<body id="kt_app_body" data-kt-app-layout="light-sidebar" data-kt-app-header-fixed="true"
      data-kt-app-sidebar-enabled="true" data-kt-app-sidebar-fixed="true" data-kt-app-sidebar-hoverable="true"
      data-kt-app-sidebar-push-header="true" data-kt-app-sidebar-push-toolbar="true"
      data-kt-app-sidebar-push-footer="true" data-kt-app-toolbar-enabled="true" class="app-default">
@include('layouts.partials.theme-mode')
<div class="d-flex flex-column flex-root app-root" id="kt_app_root">
    <div class="app-page flex-column flex-column-fluid" id="kt_app_page">
        @include('layouts.partials.admin.header')
        <div class="app-wrapper flex-column flex-row-fluid" id="kt_app_wrapper">
            @include('layouts.partials.admin.sidebar')
            <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
                @yield('content')
                @include('layouts.partials.admin.footer')
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('assets/lang/translation.'.app()->getLocale().'.js') }}"></script>
@include('layouts.partials.scroll-top')
@include('layouts.partials.scripts')
@include('layouts.partials.admin.toggle-sidebar')
@stack('scripts')
</body>
</html>
