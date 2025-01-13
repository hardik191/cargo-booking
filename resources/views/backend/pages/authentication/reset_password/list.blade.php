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
							<div class="d-flex flex-center flex-column flex-column-fluid pb-15 pb-lg-5">
								<!--begin::Form-->
								<form class="form w-100" id="reset-password" action="{{route('submit-reset-password')}}" method="POST">
                                    @csrf
									<div class="text-center mb-10">
										<img class="d-none d-lg-block mx-auto w-275px w-md-50 w-xl-300px" src="{{ asset('backend/upload/system_setting/' . $branding_setting_details->login_icon_name) }}" alt="{{ $general_setting_details->system_name }}" alt="" />

										<h1 class="text-gray-900 fw-bolder mb-3 mt-5">Setup New Password</h1>
										<!--end::Title-->
										<!--begin::Link-->
										<div class="text-gray-500 fw-semibold fs-6">Have you already reset the password ?
										<a href="{{ route('login') }}" class="link-primary fw-bold">Login</a></div>
										<!--end::Link-->
									</div>

									<input type="hidden" name="token" value="{{ $token }}">



									<div class="fv-row"  data-kt-password-meter="true">
                                        <!--begin::Password-->
                                        <div class="input-group position-relative ">
											<input class="form-control form-control-lg input-group-required" type="password" placeholder="Password" name="password" id="password" autocomplete="off" data-kt-translate="sign-up-input-password" />
                                            <span class="input-group-text" data-kt-password-meter-control="visibility">
                                                <i class="ki-duotone ki-eye-slash fs-1"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span></i>
                                                <i class="ki-duotone ki-eye d-none fs-1"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
                                            </span>

                                        </div>
										<div class="d-flex align-items-center mb-3 mt-5" data-kt-password-meter-control="highlight">
											<div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2 "></div>
											<div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
											<div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
											<div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px"></div>
										</div>
										<div class="text-muted">Use 8 or more characters with a mix of letters, numbers &amp; symbols.<div></div></div>
                                        <div class="help-block password-error mb-8"></div>
                                    </div>

									<div class="fv-row" data-kt-password-meter="true">
                                        <!--begin::Password-->
                                        <div class="input-group position-relative">
											<input class="form-control form-control-lg input-group-required" type="password" placeholder="Confirm password" name="confirm_password" id="confirm_password" autocomplete="off" data-kt-translate="sign-up-input-password"/>                                            <span class="input-group-text" data-kt-password-meter-control="visibility">
                                                <i class="ki-duotone ki-eye-slash fs-1"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span></i>
                                                <i class="ki-duotone ki-eye d-none fs-1"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
                                            </span>

                                        </div>

                                        <div class="help-block confirm-password-error"></div>
                                    </div>

									<div class="d-grid mb-10 mt-8">
										<button type="submit" id="kt_sign_in_submit" class="btn btn-primary submitbtn">
											<!--begin::Indicator label-->
											<span class="indicator-label">Submit</span>
											<!--end::Indicator label-->
											<!--begin::Indicator progress-->
											<span class="indicator-progress">Please wait...
											<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
											<!--end::Indicator progress-->
										</button>
									</div>
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
