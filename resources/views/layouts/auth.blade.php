<!DOCTYPE html>
<html lang="en">

<head>
    <base href="{{ config('settings.app_url') }}" />
    <title>@yield('title', config('settings.app_name')) | {{ config('settings.app_name') }}</title>
    <meta charset="utf-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name="description" content="{{ config('settings.app_description') }}" />
    <meta name="keywords" content="{{ config('settings.app_keywords') }}" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta property="og:locale" content="en_US" />
    <meta property="og:type" content="article" />
    <meta property="og:title" content="@yield('title', config('settings.app_name')) by {{ config('settings.app_name') }}" />
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:site_name" content="{{ config('settings.app_name') }}" />
    <link rel="canonical" href="{{ url()->current() }}" />
    <link rel="shortcut icon" href="{{ asset(config('settings.app_favicon')) }}" />
    @stack('styles')
    @include('layouts.partials.styles')
    @include('layouts.partials.click-jacking')
</head>

<body id="kt_body" class="app-blank bgi-size-cover bgi-attachment-fixed bgi-position-center">
    @include('layouts.partials.theme-mode')
    <!--begin::Root-->
    <div class="d-flex flex-column flex-root" id="kt_app_root">
        <!--begin::Page bg image-->
        <style>
            body {
                background-image: url('{{ asset('assets/media/auth/bg10.jpeg') }}');
            }

            [data-bs-theme="dark"] body {
                background-image: url('{{ asset('assets/media/auth/bg10-dark.jpeg') }}');
            }
        </style>
        <!--end::Page bg image-->
        @yield('content')
    </div>
    <!--end::Root-->
    <script src="{{ asset('assets/lang/auth.js') }}"></script>
    <script src="{{ asset('assets/lang/validation.js') }}"></script>
    @include('layouts.partials.scroll-top')
    @include('layouts.partials.scripts')
    @stack('scripts')
</body>

</html>
