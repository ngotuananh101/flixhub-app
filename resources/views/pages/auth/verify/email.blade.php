@extends('layouts.auth')

@section('title', __('auth.verify_your_email'))

@section('content')
    <!--begin::Authentication - Sign-up -->
    <div class="d-flex flex-column flex-lg-row flex-column-fluid justify-content-center">
        <!--begin::Body-->
        <div class="d-flex flex-column-fluid flex-lg-row-auto justify-content-center justify-content-lg-end p-12">
            <!--begin::Wrapper-->
            <div class="bg-body d-flex flex-column flex-center rounded-4 w-md-600px p-10">
                <!--begin::Content-->
                <div class="d-flex flex-center flex-column align-items-stretch h-lg-100 w-md-400px">
                    <!--begin::Wrapper-->
                    <div class="d-flex flex-center flex-column flex-column-fluid">
                        <!--begin::Form-->
                        <form class="form w-100" novalidate="novalidate" id="verify_form"
                              action="{{ route('verification.send') }}" method="POST">
                            @csrf
                            <!--begin::Heading-->
                            <div class="text-center mb-11">
                                <!--begin::Title-->
                                <h1 class="text-gray-900 fw-bolder mb-3">
                                    {{ __('auth.verify_your_email') }}
                                </h1>
                                <!--end::Title-->
                                <!--begin::Subtitle-->
                                <div class="text-gray-500 fw-semibold fs-6">
                                    {{ __('auth.verify_email_subtitle') }}
                                </div>
                                <!--end::Subtitle=-->
                            </div>
                            <!--begin::Heading-->
                            <!--begin::Submit button-->
                            <div class="d-grid mb-10">
                                <button type="submit" id="verify_submit" class="btn btn-primary">
                                    <!--begin::Indicator label-->
                                    <span class="indicator-label">
                                        {{ __('auth.resend') }}
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
                            <!--begin::Image-->
                            <div class="mb-0">
                                <img src="{{ asset('assets/media/auth/verify-email.png') }}" class="mw-100 mh-300px" alt="">
                            </div>
                            <!--end::Image-->
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
    <!--end::Authentication - Sign-up-->
@endsection
@push('scripts')
    <script src="{{ asset('assets/js/custom/auth/email-verify.js') }}"></script>
@endpush
