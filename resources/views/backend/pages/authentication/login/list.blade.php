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
	<body id="kt_body" class="app-blank">
		<!--begin::Theme mode setup on page load-->
		<script>var defaultThemeMode = "light"; var themeMode; if ( document.documentElement ) { if ( document.documentElement.hasAttribute("data-bs-theme-mode")) { themeMode = document.documentElement.getAttribute("data-bs-theme-mode"); } else { if ( localStorage.getItem("data-bs-theme") !== null ) { themeMode = localStorage.getItem("data-bs-theme"); } else { themeMode = defaultThemeMode; } } if (themeMode === "system") { themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light"; } document.documentElement.setAttribute("data-bs-theme", themeMode); }
        </script>
		<!--end::Theme mode setup on page load-->
		<!--begin::Root-->
		<div class="d-flex flex-column flex-root" id="kt_app_root">
			<!--begin::Authentication - Sign-in -->
			<div class="d-flex flex-column flex-lg-row flex-column-fluid">
				<!--begin::Body-->
				<div class="d-flex flex-column flex-lg-row-fluid w-lg-50 p-10 order-1 order-lg-2">
					<!--begin::Form-->
					<div class="d-flex flex-center flex-column flex-lg-row-fluid">
						<!--begin::Wrapper-->
						<div class="w-lg-500px p-10">
							<!--begin::Form-->
							<form class="form w-100" id="login-form" action="{{route('check-login')}}" method="POST">
                                @csrf
								<!--begin::Heading-->
								<div class="text-center mb-11">
									<!--begin::Title-->
									<h1 class="text-gray-900 fw-bolder mb-3">Sign In</h1>
									<!--end::Title-->
									<!--begin::Subtitle-->
									<div class="text-gray-500 fw-semibold fs-6">Your Social Campaigns</div>
									<!--end::Subtitle=-->
								</div>
								<!--begin::Heading-->



								<!--begin::Input group=-->
								<div class="fv-row mb-8">
									<!--begin::Email-->
									<input type="text" placeholder="Email" name="email" autocomplete="off" class="form-control bg-transparent" />
									<!--end::Email-->
								</div>
								<!--end::Input group=-->
								<div class="fv-row mb-3">
									<!--begin::Password-->
									<input type="password" placeholder="Password" name="password" autocomplete="off" class="form-control bg-transparent password-required" />
                                    <div class="help-block password-error"></div>
									<!--end::Password-->
								</div>
								<!--end::Input group=-->

								<!--begin::Submit button-->
								<div class="d-grid mb-10">
									<button type="submit"  class="btn btn-primary">
										<!--begin::Indicator label-->
										<span class="indicator-label">Sign In</span>
										<!--end::Indicator label-->

									</button>
								</div>
								<!--end::Submit button-->

							</form>
							<!--end::Form-->
						</div>
						<!--end::Wrapper-->
					</div>
					<!--end::Form-->
					<!--begin::Footer-->
					<div class="text-center">

                            <a href="{{$general_setting_details->footer_link}}"
                                class=" text-hover-primary text-muted">{{$general_setting_details->footer_text}}</a>

					</div>
					<!--end::Footer-->
				</div>
				<!--end::Body-->
				<!--begin::Aside-->
				<div class="d-flex flex-lg-row-fluid w-lg-50 bgi-size-cover bgi-position-center order-2 order-lg-1" style="background-image: url({{asset('backend/media/misc/auth-bg.png')}})">
					<!--begin::Content-->
					<div class="d-flex flex-column flex-center py-7 py-lg-15 px-5 px-md-15 w-100">
						<!--begin::Logo-->
						{{-- <a href="index.html" class="mb-0 mb-lg-12">
							<img alt="Logo" src="{{asset('backend/media/logos/custom-1.png')}}" class="h-60px h-lg-75px" />
						</a> --}}
						<!--end::Logo-->
						<!--begin::Image-->
						<img class="d-none d-lg-block mx-auto w-275px w-md-50 w-xl-500px mb-10 mb-lg-20" src="{{ asset('backend/upload/system_setting/' . $branding_setting_details->login_icon_name) }}" alt="{{ $general_setting_details->system_name }}" alt="" />
						<!--end::Image-->
						<!--begin::Title-->
						<h1 class="d-none d-lg-block text-white fs-2qx fw-bolder text-center mb-7">Fast, Efficient and Productive</h1>
						<!--end::Title-->
						<!--begin::Text-->
						<div class="d-none d-lg-block text-white fs-base text-center">In this kind of post,
						<a href="#" class="opacity-75-hover text-warning fw-bold me-1">the blogger</a>introduces a person they’ve interviewed
						<br />and provides some background information about
						<a href="#" class="opacity-75-hover text-warning fw-bold me-1">the interviewee</a>and their
						<br />work following this is a transcript of the interview.</div>
						<!--end::Text-->
					</div>
					<!--end::Content-->
				</div>
				<!--end::Aside-->
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
