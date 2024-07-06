@extends('layouts.auth')

@section('title', __('auth.reset_password'))

@section('content')
    <!--begin::Authentication - New password -->
    <div class="d-flex flex-column flex-lg-row flex-column-fluid justify-content-center">
        <!--begin::Body-->
        <div class="d-flex flex-column-fluid flex-lg-row-auto justify-content-center justify-content-lg-end p-12">
            <!--begin::Wrapper-->
            <div class="bg-body d-flex flex-column flex-center rounded-4 w-md-600px p-10">
                <!--begin::Content-->
                <div class="d-flex flex-center flex-column align-items-stretch h-lg-100 w-md-400px">
                    <!--begin::Wrapper-->
                    <div class="d-flex flex-center flex-column flex-column-fluid pb-15 pb-lg-20">
                        <!--begin::Form-->
                        <form class="form w-100" novalidate="novalidate" id="new_password_form"
                            action="{{ route('auth.new-password') }}" method="POST">
                            @csrf
                            <input type="hidden" name="token" value="{{ $token }}" />
                            <input type="hidden" name="email" value="{{ $email }}" />
                            <!--begin::Heading-->
                            <div class="text-center mb-10">
                                <!--begin::Title-->
                                <h1 class="text-gray-900 fw-bolder mb-3">
                                    {{ __('auth.reset_password') }}
                                </h1>
                                <!--end::Title-->
                                <!--begin::Link-->
                                <div class="text-gray-500 fw-semibold fs-6">
                                    {{ __('auth.reset_password_subtitle') }}
                                    <a href="{{ route('auth.login') }}" class="link-primary fw-bold">
                                        {{ __('auth.login') }}
                                    </a>
                                </div>
                                <!--end::Link-->
                            </div>
                            <!--begin::Heading-->
                            <!--begin::Input group-->
                            <div class="fv-row mb-8" data-kt-password-meter="true">
                                <!--begin::Wrapper-->
                                <div class="mb-1">
                                    <!--begin::Input wrapper-->
                                    <div class="position-relative mb-3">
                                        <input class="form-control bg-transparent" type="password"
                                            placeholder="{{ __('auth.password2') }}" name="password" autocomplete="off" />
                                        <span
                                            class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2"
                                            data-kt-password-meter-control="visibility">
                                            <i class="ki-duotone ki-eye-slash fs-2">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                                <span class="path3"></span>
                                                <span class="path4"></span>
                                            </i>
                                            <i class="ki-duotone ki-eye fs-2 d-none">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                                <span class="path3"></span>
                                            </i>
                                        </span>
                                    </div>
                                    <!--end::Input wrapper-->
                                    <!--begin::Meter-->
                                    <div class="d-flex align-items-center mb-3" data-kt-password-meter-control="highlight">
                                        <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                                        <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                                        <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                                        <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px"></div>
                                    </div>
                                    <!--end::Meter-->
                                </div>
                                <!--end::Wrapper-->
                                <!--begin::Hint-->
                                <div class="text-muted">
                                    {{ __('auth.password_hint') }}
                                </div>
                                <!--end::Hint-->
                            </div>
                            <!--end::Input group=-->
                            <!--end::Input group=-->
                            <div class="fv-row mb-8">
                                <!--begin::Repeat Password-->
                                <input type="password" placeholder="{{ __('auth.password_confirmation') }}" name="password_confirmation"
                                    autocomplete="off" class="form-control bg-transparent" />
                                <!--end::Repeat Password-->
                                <!--begin::Hint-->
                                <div class="text-muted">
                                    {{ __('auth.password_confirmation_hint') }}
                                </div>
                            </div>
                            <!--end::Input group=-->
                            <!--begin::Input group=-->
                            <div class="fv-row mb-8">
                                <label class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="toc" value="1" />
                                    <span class="form-check-label fw-semibold text-gray-700 fs-6 ms-1">
                                        {{ __('auth.agree_terms') }}
                                    </span>
                                </label>
                            </div>
                            <!--end::Input group=-->
                            <!--begin::Action-->
                            <div class="d-grid mb-10">
                                <button type="button" id="new_password_submit" class="btn btn-primary">
                                    <!--begin::Indicator label-->
                                    <span class="indicator-label">
                                        {{ __('auth.submit') }}
                                    </span>
                                    <!--end::Indicator label-->
                                    <!--begin::Indicator progress-->
                                    <span class="indicator-progress">
                                        {{ __('auth.please_wait') }}
                                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                    <!--end::Indicator progress-->
                                </button>
                            </div>
                            <!--end::Action-->
                        </form>
                        <!--end::Form-->
                    </div>
                    <!--end::Wrapper-->
                    @include('layouts.partials.auth.footer')
                </div>
                <!--end::Content-->
            </div>
            <!--end::Wrapper-->
        </div>
        <!--end::Body-->
    </div>
    <!--end::Authentication - New password-->
@endsection

@push('scripts')
    <script src="{{ asset('assets/js/custom/auth/reset-password.js') }}"></script>
@endpush
