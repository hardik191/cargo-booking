@extends('error/layout/layout')
@section('content_error')

    <div class="d-flex flex-column flex-root" id="kt_app_root">
        <style>
            body {
                background-image: url('{{ asset('backend/media/auth/bg1.jpg') }}');
            }
            [data-bs-theme="dark"] body {
                background-image: url('{{ asset('backend/media/auth/bg1-dark.jpg') }}');
            }
        </style>

        <!--end::Page bg image-->
        <!--begin::Authentication - Signup Welcome Message -->
        <div class="d-flex flex-column flex-center flex-column-fluid">
            <!--begin::Content-->
            <div class="d-flex flex-column flex-center text-center p-10">
                <!--begin::Wrapper-->
                <div class="card card-flush w-lg-650px py-5">
                    <div class="card-body py-20 py-lg-20">
                        <!--begin::Title-->

                        <h1 class=""><i class="fa-solid fa-circle-xmark text-danger" style="font-size: 100px"></i></h1>
                        <!--end::Title-->
                        <!--begin::Text-->

                        <!--end::Text-->
                        <!--begin::Illustration-->
                        <div class="mb-3">
                            <h1 class="display-6">Access Denied</h1>
                            <div class="fw-semibold fs-3 text-gray-600 m-3">You do not have permission to view this page.
                                <br>
                                Please check your credentials and try again.
                            </div>
                            <div class="fw-bold fs-3 text-gray-600 mb-7">
                                Error Code: 403
                            </div>

                        </div>
                        <!--end::Illustration-->
                        <!--begin::Link-->
                        <div class="mb-0">
                            <a href="{{ route('login') }}" class="btn btn-sm btn-primary">Sign In</a>
                        </div>
                        <!--end::Link-->
                    </div>
                </div>
                <!--end::Wrapper-->
            </div>
            <!--end::Content-->
        </div>
    </div>

    @endsection
