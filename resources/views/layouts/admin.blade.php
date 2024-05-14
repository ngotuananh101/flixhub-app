<!DOCTYPE html>
<html lang="en">

<head>
    <base href="{{ config('app.url') }}"/>
    <title>@yield('title', config('app.name')) | {{ config('app.name') }}</title>
    <meta charset="utf-8"/>
    <meta name="description"
          content="The most advanced Bootstrap 5 Admin Theme with 40 unique prebuilt layouts on Themeforest trusted by 100,000 beginners and professionals. Multi-demo, Dark Mode, RTL support and complete React, Angular, Vue, Asp.Net Core, Rails, Spring, Blazor, Django, Express.js, Node.js, Flask, Symfony & Laravel versions. Grab your copy now and get life-time updates for free."/>
    <meta name="keywords"
          content="metronic, bootstrap, bootstrap 5, angular, VueJs, React, Asp.Net Core, Rails, Spring, Blazor, Django, Express.js, Node.js, Flask, Symfony & Laravel starter kits, admin themes, web design, figma, web development, free templates, free admin themes, bootstrap theme, bootstrap template, bootstrap dashboard, bootstrap dak mode, bootstrap button, bootstrap datepicker, bootstrap timepicker, fullcalendar, datatables, flaticon"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <meta property="og:locale" content="en_US"/>
    <meta property="og:type" content="article"/>
    <meta property="og:title" content="Metronic - The World's #1 Selling Bootstrap Admin Template by KeenThemes"/>
    <meta property="og:url" content="https://keenthemes.com/metronic"/>
    <meta property="og:site_name" content="Metronic by Keenthemes"/>
    <link rel="canonical" href="http://layouts/light-sidebar.html"/>
    <link rel="shortcut icon" href="assets/media/logos/favicon.ico"/>
    @include('layouts.partials.styles')
    @include('layouts.partials.click-jacking')
    @stack('styles')
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
@include('layouts.partials.scroll-top')
@include('layouts.partials.scripts')
@stack('scripts')
</body>
</html>
