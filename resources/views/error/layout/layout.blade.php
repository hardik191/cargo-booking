@php
    $get_system_setting = get_system_setting('branding');
    $branding_details = json_decode($get_system_setting['value']);


    if(isset($branding_details->favicon_icon_name) ){
        $favicon_icon = url("backend/upload/system_setting/".$branding_details->favicon_icon_name);
    }else{
        $favicon_icon = url("backend/upload/system_setting/default_no_image.png");
    }
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{-- <link rel="canonical" href="http://dashboards/projects.html" /> --}}
    <link rel="shortcut icon" href="{{ $favicon_icon }}" />
    <!--begin::Fonts(mandatory for all pages)-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
    <!--end::Fonts-->
    <!--begin::Global Stylesheets Bundle(mandatory for all pages)-->
    <link href="{{ asset('backend/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('backend/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />
    {{-- <link href="{{ asset('backend/css/style.css') }}" rel="stylesheet" type="text/css" /> --}}
    <link href="{{ asset('backend/plugins/global/fonts/fontawesome/font_cdn.css') }}" rel="stylesheet" type="text/css" />
    <title>{{$title}}</title>
</head>
<body id="kt_body" class="app-blank bgi-size-cover bgi-position-center bgi-no-repeat">
    @yield('content_error')

    {{-- <script src="{{ asset('backend/plugins/global/plugins.bundle.js') }}"></script> --}}
    <script src="{{ asset('backend/js/scripts.bundle.js') }}"></script>
 
</body>

</html>
