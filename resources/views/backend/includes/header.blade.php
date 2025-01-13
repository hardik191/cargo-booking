@php
    $get_system_setting = get_system_setting('branding');
$branding_details = json_decode($get_system_setting['value']);


    if(isset($branding_details->favicon_icon_name) ){
        $favicon_icon = url("backend/upload/system_setting/".$branding_details->favicon_icon_name);
    }else{
        $favicon_icon = url("backend/upload/system_setting/default_no_image.png");
    }

@endphp
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
    <link href="{{ asset('backend/css/style.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('backend/plugins/global/fonts/fontawesome/font_cdn.css') }}" rel="stylesheet" type="text/css" />
    <title>{{$title}}</title>


    <style>
        [data-kt-app-layout=dark-sidebar] .app-sidebar {
            background-color: {{isset($branding_details->sidebar_color) ? $branding_details->sidebar_color : '#000000'}};
        }

        [data-kt-app-layout=dark-sidebar] .app-sidebar .menu .menu-item .menu-link {
            color:{{isset($branding_details->sidebar_menu_font_color) ? $branding_details->sidebar_menu_font_color : '#9a9cae'}} !important;
        }

        [data-kt-app-layout=dark-sidebar] .app-sidebar .menu .menu-item .menu-link .menu-icon, [data-kt-app-layout=dark-sidebar] .app-sidebar .menu .menu-item .menu-link .menu-icon .svg-icon, [data-kt-app-layout=dark-sidebar] .app-sidebar .menu .menu-item .menu-link .menu-icon i {
            color: {{isset($branding_details->sidebar_menu_font_color) ? $branding_details->sidebar_menu_font_color : '#9a9cae'}} !important;
        }

        [data-kt-app-layout=dark-sidebar] .app-sidebar .menu .menu-item .menu-link .menu-title {
            color: {{isset($branding_details->sidebar_menu_font_color) ? $branding_details->sidebar_menu_font_color : '#9a9cae'}} !important;
        }

        [data-kt-app-layout=dark-sidebar] .app-sidebar .menu .menu-item .menu-link.active {
            transition: color .2s ease;
            background-color: {{isset($branding_details->sidebar_active_color) ? $branding_details->sidebar_active_color : '#1c1c21'}} !important;
            color:  {{isset($branding_details->sidebar_active_font_color) ? $branding_details->sidebar_active_font_color : '#f5f5f5'}} !important;
        }

        [data-kt-app-layout=dark-sidebar] .app-sidebar .menu .menu-item.hover:not(.here)>.menu-link:not(.disabled):not(.active):not(.here) .menu-title, [data-kt-app-layout=dark-sidebar] .app-sidebar .menu .menu-item:not(.here) .menu-link:hover:not(.disabled):not(.active):not(.here) .menu-title {
            color:  {{isset($branding_details->sidebar_menu_font_color) ? $branding_details->sidebar_menu_font_color : '#9a9cae'}} !important;
        }

        /* [data-kt-app-layout=dark-sidebar] .app-sidebar .menu .menu-item.show>.menu-link .menu-title {
            color:  {{isset($branding_details->hover_color) ? $branding_details->hover_color : '#f5f5f5'}} !important;
        }

        [data-kt-app-layout=dark-sidebar] .app-sidebar .menu .menu-item.here>.menu-link .menu-title {
            color:  {{isset($branding_details->hover_color) ? $branding_details->hover_color : '#f5f5f5'}} !important;

        } */

        [data-kt-app-layout=dark-sidebar] .app-sidebar .menu .menu-item .menu-link.active, #kt_app_sidebar span.menu-link:hover, #kt_app_sidebar .menu-sub .menu-item:hover {
            transition: color .2s ease;
            background-color: {{isset($branding_details->sidebar_active_color) ? $branding_details->sidebar_active_color : '#1c1c21'}} !important;
            color:{{isset($branding_details->sidebar_active_font_color) ? $branding_details->sidebar_active_font_color : '#f5f5f5'}} !important;
        }

        #kt_app_header{
            top: 1px; background: #FCFCFC; border-bottom:1px dashed {{isset($branding_details->sidebar_color) ? $branding_details->sidebar_color : '#000000'}};
        }

        [data-kt-app-layout=dark-sidebar] .app-sidebar .menu .menu-item.show>.menu-link {
            transition: color .2s ease;
            background-color: {{isset($branding_details->sidebar_active_color) ? $branding_details->sidebar_active_color : '#1c1c21'}} !important;
            color:{{isset($branding_details->sidebar_active_font_color) ? $branding_details->sidebar_active_font_color : '#f5f5f5'}} !important;
        }
        /* primary_color */
        .btn.btn-primary {
            color: {{isset($branding_details->primary_color_text) ? $branding_details->primary_color_text : '#ffffff'}} !important;
            border-color: {{isset($branding_details->primary_color) ? $branding_details->primary_color : '#1b84ff'}} !important;
            background-color: {{isset($branding_details->primary_color) ? $branding_details->primary_color : '#1b84ff'}} !important;
        }

        .btn.btn-primary .svg-icon, .btn.btn-primary i {
            color: {{isset($branding_details->primary_color_text) ? $branding_details->primary_color_text : '#ffffff'}} !important;
        }

        .btn-check:active+.btn.btn-primary, .btn-check:checked+.btn.btn-primary, .btn.btn-primary.active, .btn.btn-primary.show, .btn.btn-primary:active:not(.btn-active), .btn.btn-primary:focus:not(.btn-active), .btn.btn-primary:hover:not(.btn-active), .show>.btn.btn-primary {
            color: {{isset($branding_details->hover_font_color) ? $branding_details->hover_font_color : '#ffffff'}} !important;
            border-color: {{isset($branding_details->hover_color) ? $branding_details->hover_color : '#1b84ff'}} !important;
            background-color: {{isset($branding_details->hover_color) ? $branding_details->hover_color : '#1b84ff'}} !important;
        }

        .btn-check:active+.btn.btn-primary .svg-icon, .btn-check:active+.btn.btn-primary i, .btn-check:checked+.btn.btn-primary .svg-icon, .btn-check:checked+.btn.btn-primary i, .btn.btn-primary.active .svg-icon, .btn.btn-primary.active i, .btn.btn-primary.show .svg-icon, .btn.btn-primary.show i, .btn.btn-primary:active:not(.btn-active) .svg-icon, .btn.btn-primary:active:not(.btn-active) i, .btn.btn-primary:focus:not(.btn-active) .svg-icon, .btn.btn-primary:focus:not(.btn-active) i, .btn.btn-primary:hover:not(.btn-active) .svg-icon, .btn.btn-primary:hover:not(.btn-active) i, .show>.btn.btn-primary .svg-icon, .show>.btn.btn-primary i {
            color:{{isset($branding_details->hover_font_color) ? $branding_details->hover_font_color : '#ffffff'}} !important;
        }

        /* aa */

    </style>
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
</head>
