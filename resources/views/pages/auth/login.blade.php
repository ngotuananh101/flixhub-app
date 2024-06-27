@extends('layouts.auth')

@section('title', __('auth.login'))

@section('content')
    <!--begin::Authentication - Sign-in -->
    <div class="d-flex flex-column flex-lg-row flex-column-fluid justify-content-center">
        <!--begin::Body-->
        <div class="d-flex flex-column-fluid flex-lg-row-auto justify-content-center p-12">
            <!--begin::Wrapper-->
            <div class="bg-body d-flex flex-column flex-center rounded-4 w-md-600px p-10">
                <!--begin::Content-->
                <div class="d-flex flex-center flex-column align-items-stretch h-lg-100 w-md-400px">
                    <!--begin::Wrapper-->
                    <div class="d-flex flex-center flex-column flex-column-fluid pb-15 pb-lg-20">
                        @include('layouts.partials.alerts')
                        <!--begin::Form-->
                        <form class="form w-100" novalidate="novalidate" id="sign_in_form" method="POST" action="{{ route('auth.login') }}">
                            @csrf
                            <!--begin::Heading-->
                            <div class="text-center mb-11">
                                <!--begin::Title-->
                                <h1 class="text-gray-900 fw-bolder mb-3">
                                    {{ __('auth.login') }}
                                </h1>
                                <!--end::Title-->
                                <!--begin::Subtitle-->
                                <div class="text-gray-500 fw-semibold fs-6">
                                    {{ __('auth.login_subtitle') }}
                                </div>
                                <!--end::Subtitle=-->
                            </div>
                            <!--begin::Heading-->
                            <!--begin::Login options-->
                            <div class="row g-3 mb-9">
                                <!--begin::Col-->
                                <div class="col-md-6">
                                    <!--begin::Google link=-->
                                    <a href="{{ route('auth.redirectToProvider', 'google') }}"
                                        class="btn btn-flex btn-outline btn-text-gray-700 btn-active-color-primary bg-state-light flex-center text-nowrap w-100">
                                        <img alt="Logo" src="{{ asset('assets/media/svg/brand-logos/google-icon.svg') }}"
                                            class="h-15px me-3" />
                                            {{ __('auth.sign_in_with_google') }}
                                        </a>
                                    <!--end::Google link=-->
                                </div>
                                <!--end::Col-->
                                <!--begin::Col-->
                                <div class="col-md-6">
                                    <!--begin::Google link=-->
                                    <a href="#"
                                        class="btn btn-flex btn-outline btn-text-gray-700 btn-active-color-primary bg-state-light flex-center text-nowrap w-100">
                                        <img alt="Logo" src="{{ asset('assets/media/svg/brand-logos/facebook-icon.svg') }}"
                                            class="h-15px me-3" />
                                        {{ __('auth.sign_in_with_facebook') }}
                                        </a>
                                    <!--end::Google link=-->
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Login options-->
                            <!--begin::Separator-->
                            <div class="separator separator-content my-14">
                                <span class="w-125px text-gray-500 fw-semibold fs-7">
                                    {{ __('auth.or_with_email') }}
                                </span>
                            </div>
                            <!--end::Separator-->
                            <!--begin::Input group=-->
                            <div class="fv-row mb-8">
                                <!--begin::Email-->
                                <input type="text" placeholder="{{ __('auth.email') }}" name="email" autocomplete="off"
                                    class="form-control bg-transparent" />
                                @error('email')
                                <div class="fv-plugins-message-container">
                                    <div data-field="email" data-validator="notEmpty" class="fv-help-block">{{ $message }}</div>
                                </div>
                                @enderror
                                <!--end::Email-->
                            </div>
                            <!--end::Input group=-->
                            <div class="fv-row mb-3">
                                <!--begin::Password-->
                                <input type="password" placeholder="{{ __('auth.password') }}" name="password" autocomplete="off"
                                    class="form-control bg-transparent" />
                                <!--end::Password-->
                            </div>
                            <!--end::Input group=-->
                            <!--begin::Wrapper-->
                            <div class="d-flex flex-stack flex-wrap gap-3 fs-base fw-semibold mb-8">
                                <div></div>
                                <!--begin::Link-->
                                <a href="authentication/layouts/overlay/reset-password.html"
                                    class="link-primary">
                                    {{ __('auth.forgot_password') }} ?
                                </a>
                                <!--end::Link-->
                            </div>
                            <!--end::Wrapper-->
                            <!--begin::Submit button-->
                            <div class="d-grid mb-10">
                                <button type="submit" id="kt_sign_in_submit" class="btn btn-primary">
                                    <!--begin::Indicator label-->
                                    <span class="indicator-label">
                                        {{ __('auth.login') }}
                                    </span>
                                    <!--end::Indicator label-->
                                    <!--begin::Indicator progress-->
                                    <span class="indicator-progress">
                                        {{ __('auth.please_wait') }}
                                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                    </span>
                                    <!--end::Indicator progress-->
                                </button>
                            </div>
                            <!--end::Submit button-->
                            <!--begin::Sign up-->
                            <div class="text-gray-500 text-center fw-semibold fs-6">
                                {{ __('auth.not_member_yet') }}
                                <a href="authentication/layouts/overlay/sign-up.html" class="link-primary">
                                    {{ __('auth.register') }}
                                </a>
                            </div>
                            <!--end::Sign up-->
                        </form>
                        <!--end::Form-->
                    </div>
                    <!--end::Wrapper-->
                    <!--begin::Footer-->
                    <div class="d-flex flex-stack">
                        <!--begin::Languages-->
                        <div class="me-10">
                            <!--begin::Toggle-->
                            <button
                                class="btn btn-flex btn-link btn-color-gray-700 btn-active-color-primary rotate fs-base"
                                data-kt-menu-trigger="click" data-kt-menu-placement="bottom-start"
                                data-kt-menu-offset="0px, 0px">
                                <img data-kt-element="current-lang-flag" class="w-20px h-20px rounded me-3"
                                    src="{{ asset('assets/media/flags/united-states.svg') }}" alt="" />
                                <span data-kt-element="current-lang-name" class="me-1">English</span>
                                <i class="ki-duotone ki-down fs-5 text-muted rotate-180 m-0"></i>
                            </button>
                            <!--end::Toggle-->
                            <!--begin::Menu-->
                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px py-4 fs-7"
                                data-kt-menu="true" id="kt_auth_lang_menu">
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="#" class="menu-link d-flex px-5" data-kt-lang="English">
                                        <span class="symbol symbol-20px me-4">
                                            <img data-kt-element="lang-flag" class="rounded-1"
                                                src="{{ asset('assets/media/flags/united-states.svg') }}" alt="" />
                                        </span>
                                        <span data-kt-element="lang-name">English</span>
                                    </a>
                                </div>
                                <!--end::Menu item-->
                            </div>
                            <!--end::Menu-->
                        </div>
                        <!--end::Languages-->
                        <!--begin::Links-->
                        <div class="d-flex fw-semibold text-primary fs-base gap-5">
                            <a href="{{ env('SOCIAL_FACEBOOK') }}" target="_blank">Facebook</a>
                            <a href="{{ env('SOCIAL_GITHUB') }}" target="_blank">Github</a>
                            <a href="{{ env('SOCIAL_BLOG') }}" target="_blank">Blog</a>
                        </div>
                        <!--end::Links-->
                    </div>
                    <!--end::Footer-->
                </div>
                <!--end::Content-->
            </div>
            <!--end::Wrapper-->
        </div>
        <!--end::Body-->
    </div>
    <!--end::Authentication - Sign-in-->
@endsection

@push('scripts')
    <script src="{{ asset('assets/js/custom/auth/login.js') }}"></script>
@endpush