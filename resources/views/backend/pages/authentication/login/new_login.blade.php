<!DOCTYPE html>

<html lang="en">
	<!--begin::Head-->
	<head>

        @php
            $get_system_setting = get_system_setting('general_setting');
            $general_setting_details = json_decode($get_system_setting['value']);

            $get_branding_setting = get_system_setting('branding');
            $branding_setting_details = json_decode($get_branding_setting['value']);
        @endphp
		<title>{{$title}}</title>
		<meta charset="utf-8" />
		<meta name="description" content="{{$general_setting_details->system_name}}" />
		<meta name="keywords" content="{{$general_setting_details->system_name}}" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<meta property="og:locale" content="en_US" />
		<meta property="og:type" content="article" />
		<meta property="og:title" content="{{$general_setting_details->system_name}}" />
		<meta property="og:url" content="" />
		<meta property="og:site_name" content="{{$general_setting_details->system_name}}" />
		<meta name="csrf-token" content="{{ csrf_token() }}">

		<link rel="canonical" href="/" />
		<link rel="shortcut icon" href="{{ asset('backend/upload/system_setting/' . $branding_setting_details->favicon_icon_name ) }}" />
		<!--begin::Fonts(mandatory for all pages)-->
		{{-- <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" /> --}}
		<!--end::Fonts-->
		<!--begin::Global Stylesheets Bundle(mandatory for all pages)-->
		<link href="{{asset('backend/plugins/global/plugins.bundle.css')}}" rel="stylesheet" type="text/css" />
		<link href="{{asset('backend/css/style.bundle.css')}}" rel="stylesheet" type="text/css" />
		<!--end::Global Stylesheets Bundle-->
		<script>// Frame-busting to prevent site from being loaded within a frame without permission (click-jacking) if (window.top != window.self) { window.top.location.replace(window.self.location.href); }</script>
        <style>
            .help-block{
                color: red;
            }
        </style>
	</head>


    @if (!empty($css))
            @foreach ($css as $value)
                @if(!empty($value))
                    <link rel="stylesheet" href="{{ asset('backend/css/customcss/'.$value) }}">
                @endif
            @endforeach
		@endif


		@if (!empty($plugincss))
			@foreach ($plugincss as $value)
				@if(!empty($value))
					<link rel="stylesheet" href="{{ asset('backend/'.$value) }}">
				@endif
			@endforeach
		@endif
	<!--end::Head-->
	<!--begin::Body-->
	<body id="kt_body" class="app-blank" style="background-image: url({{asset('backend/media/misc/auth-bg.png')}})">
		<!--begin::Theme mode setup on page load-->
		<script>var defaultThemeMode = "light"; var themeMode; if ( document.documentElement ) { if ( document.documentElement.hasAttribute("data-bs-theme-mode")) { themeMode = document.documentElement.getAttribute("data-bs-theme-mode"); } else { if ( localStorage.getItem("data-bs-theme") !== null ) { themeMode = localStorage.getItem("data-bs-theme"); } else { themeMode = defaultThemeMode; } } if (themeMode === "system") { themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light"; } document.documentElement.setAttribute("data-bs-theme", themeMode); }
        </script>

		<div class="d-flex flex-column flex-root" id="kt_app_root">

			<div class="d-flex flex-column flex-lg-row flex-center flex-column-fluid">

				<div class="d-flex flex-column-fluid flex-lg-row-auto justify-content-center justify-content-lg-end p-12">
					<!--begin::Wrapper-->
					<div class="bg-body d-flex flex-column flex-center rounded-4 w-md-600px p-10">
						<!--begin::Content-->
						<div class="d-flex flex-center flex-column align-items-stretch h-lg-100 w-md-400px">
							<!--begin::Wrapper-->
							<div class="d-flex flex-center flex-column flex-column-fluid pb-15 pb-lg-1">
								<!--begin::Form-->
								<form class="form w-100" id="login-form" action="{{route('check-login')}}" method="POST">
                                    @csrf
									<div class="text-center mb-11">
										<!--begin::Title-->
										<img class="d-none d-lg-block mx-auto w-275px w-md-50 w-xl-300px" src="{{ asset('backend/upload/system_setting/' . $branding_setting_details->login_icon_name) }}" alt="{{ $general_setting_details->system_name }}" alt="" />

										{{-- <img class="d-none d-lg-block mx-auto w-500px w-md-50 w-xl-300px mb-5 mb-lg-5" src="{{ asset('backend/upload/system_setting/' . $branding_setting_details->sign_in_icon_name) }}" alt="{{ $general_setting_details->system_name }}" alt="" /> --}}
										<h1 class="text-gray-900 fw-bolder mb-3 mt-3">Sign In</h1>
										<div class="text-gray-500 fw-semibold fs-6">Access Your Account</div>
									</div>

									<div class="fv-row mb-8">
                                        <!--begin::Email-->
                                        <input type="text" placeholder="Email" name="email" id="email" autocomplete="off" class="form-control bg-transparent" />
                                        <!--end::Email-->
                                    </div>
                                    <!--end::Input group=-->

                                    <div class="fv-row"  data-kt-password-meter="true">
                                        <!--begin::Password-->
                                        <div class="input-group position-relative">
                                            <input type="password" placeholder="Password" name="password" id="password" autocomplete="off" class="form-control input-group-required bg-transparent password-required" />
                                            <span class="input-group-text" data-kt-password-meter-control="visibility">
                                                <i class="ki-duotone ki-eye-slash fs-1"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span></i>
                                                <i class="ki-duotone ki-eye d-none fs-1"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
                                            </span>
                                        </div>

                                        <div class="help-block password-error"></div>
                                            <!--end::Password-->
                                        <div class="d-flex flex-stack flex-wrap gap-3 fs-base fw-semibold mb-5 mt-2">
                                            <div></div>
                                            <!--begin::Link-->
                                            <a href="{{route('forgot-password')}}" class="link-primary">Forgot Password ?</a>
                                            <!--end::Link-->
                                        </div>
                                    </div>


									<!--end::Wrapper-->
									<!--begin::Submit button-->
									<div class="d-grid mb-10">
										<div class="d-grid mb-10">
                                            <button type="submit"  class="btn btn-primary submitbtn" >
                                                <!--begin::Indicator label-->
                                                <span class="indicator-label">Sign In</span>
                                                <span class="indicator-progress">Please wait...
                                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                            </button>
                                        </div>
									</div>
									<!--end::Submit button-->
									<!--begin::Sign up-->
									{{-- <div class="text-gray-500 text-center fw-semibold fs-6">Not a Member yet?
									<a href="authentication/layouts/overlay/sign-up.html" class="link-primary">Sign up</a></div> --}}
									<!--end::Sign up-->
								</form>
								<!--end::Form-->
							</div>

							<!--end::Wrapper-->
							<!--begin::Footer-->
							<div class="text-center">
                                <a href="{{$general_setting_details->footer_link}}"
                                    class=" text-hover-primary text-muted">{{$general_setting_details->footer_text}}</a>

                        	</div>
						</div>
						<!--end::Content-->
					</div>
					<!--end::Wrapper-->
				</div>
				<!--end::Body-->
			</div>
			<!--end::Authentication - Sign-in-->
		</div>
		<!--end::Root-->
		<!--begin::Javascript-->
		<script>
            var hostUrl = "{{ asset('/') }}";
            var baseurl = "{{ asset('/') }}";
        </script>
		<!--begin::Global Javascript Bundle(mandatory for all pages)-->
		<script src="{{asset('backend/plugins/global/plugins.bundle.js')}}"></script>
		<script src="{{asset('backend/js/scripts.bundle.js')}}"></script>
		<!--end::Global Javascript Bundle-->
		<!--begin::Custom Javascript(used for this page only)-->
		{{-- <script src="{{asset('backend/js/custom/authentication/sign-in/general.js')}}"></script> --}}
		<!--end::Custom Javascript-->
		<!--end::Javascript-->
	</body>

    @if (!empty($pluginjs))
    @foreach ($pluginjs as $value)
        <script src="{{ asset('backend/js/'.$value) }}" type="text/javascript"></script>
    @endforeach
    @endif

    @if (!empty($widgetjs))
    @foreach ($widgetjs as $value)
        <script src="{{ asset('backend/'.$value) }}" type="text/javascript"></script>
    @endforeach
@endif

    @if (!empty($js))
    @foreach ($js as $value)
        <script src="{{ asset('backend/js/customjs/'.$value) }}" type="text/javascript"></script>
    @endforeach
    @endif

    <script type="text/javascript">
        jQuery(document).ready(function () {
            $('#loader').show();
            $('#loader').fadeOut(2000);
        });
        </script>

    <script>

        jQuery(document).ready(function () {
            @if (!empty($funinit))
                    @foreach ($funinit as $value)
                        {{  $value }}
                    @endforeach
            @endif
        });
    </script>
	<!--end::Body-->
</html>
