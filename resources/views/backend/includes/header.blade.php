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
            background-color: {{isset($branding_details->sidebar_color) ? $branding_details->sidebar_color : '#000000'}} !important;
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

        [data-kt-app-layout=dark-sidebar] .app-sidebar .menu .menu-item.hover:not(.here)>.menu-link:not(.disabled):not(.active):not(.here) .menu-title, [data-kt-app-layout=dark-sidebar] .app-sidebar .menu .menu-item:not(.here) .menu-link:hover:not(.disabled):not(.active):not(.here) .menu-title {
            color:  {{isset($branding_details->sidebar_menu_font_color) ? $branding_details->sidebar_menu_font_color : '#9a9cae'}} !important;
        }

        [data-kt-app-layout=dark-sidebar] .app-sidebar .menu .menu-item.show>.menu-link .menu-title {
            color:  {{isset($branding_details->hover_color) ? $branding_details->hover_color : '#f5f5f5'}} !important;
        }

        [data-kt-app-layout=dark-sidebar] .app-sidebar .menu .menu-item.here>.menu-link .menu-title {
            color:  {{isset($branding_details->sidebar_menu_font_color) ? $branding_details->sidebar_menu_font_color : '#f5f5f5'}} !important;
            font-weight:bold;

        }

        [data-kt-app-layout=dark-sidebar] .app-sidebar .menu .menu-item.hover:not(.here)>.menu-link:not(.disabled):not(.active):not(.here), [data-kt-app-layout=dark-sidebar] .app-sidebar .menu .menu-item:not(.here) .menu-link:hover:not(.disabled):not(.active):not(.here) {
            transition: color .2s ease;
            background-color: {{isset($branding_details->hover_color) ? $branding_details->hover_color : '#f5f5f5'}} !important;
            color:{{isset($branding_details->sidebar_menu_font_color) ? $branding_details->sidebar_menu_font_color : '#9a9cae'}} !important;
        }

        #kt_app_sidebar .menu-sub .menu-item:hover {
            border-radius: 0.475rem;
            margin-right: 1rem;
        }

        /* Special hover state for active menu items */

        /* main manu  */
        [data-kt-app-layout=dark-sidebar] .app-sidebar .menu .menu-item.show>.menu-link {
            transition: color .2s ease;
            background-color: {{isset($branding_details->sidebar_active_color) ? $branding_details->sidebar_active_color : '#1c1c21'}} !important;
        }
        /*main menu-title  */
        [data-kt-app-layout=dark-sidebar] .app-sidebar .menu .menu-item.show>.menu-link .menu-title {
            color:  {{isset($branding_details->sidebar_active_font_color) ? $branding_details->sidebar_active_font_color : '#9a9cae'}} !important;
        }
        [data-kt-app-layout=dark-sidebar] .app-sidebar .menu .menu-item.show>.menu-link .menu-icon {
            color:  {{isset($branding_details->sidebar_active_font_color) ? $branding_details->sidebar_active_font_color : '#9a9cae'}} !important;
        }

        /* svg icon main menu*/
            /* [data-kt-app-layout=dark-sidebar] .app-sidebar .menu .menu-item.here.show .menu-icon svg {
                fill: {{ $branding_details->sidebar_active_font_color }};
            }
            [data-kt-app-layout=dark-sidebar] .app-sidebar .menu .menu-item.menu-icon svg {
                fill: {{ $branding_details->sidebar_menu_font_color }};
            } */
            /* svg icon sub menu */
            /* [data-kt-app-layout=dark-sidebar] .app-sidebar .menu .menu-item .menu-link .menu-icon svg {
                fill: {{ $branding_details->sidebar_menu_font_color }};
            }
            [data-kt-app-layout=dark-sidebar] .app-sidebar .menu .menu-item .menu-link.active .menu-icon svg {
                fill: {{ $branding_details->sidebar_active_font_color }};
            } */

        /* bullet icon color change */
        [data-kt-app-layout=dark-sidebar] .app-sidebar .menu .menu-item .menu-link .menu-bullet .bullet {
            background-color: {{isset($branding_details->sidebar_menu_font_color) ? $branding_details->sidebar_menu_font_color : '#9a9cae'}};
        }
        [data-kt-app-layout=dark-sidebar] .app-sidebar .menu .menu-item .menu-link.active .menu-bullet .bullet {
            background-color: {{isset($branding_details->sidebar_active_font_color) ? $branding_details->sidebar_active_font_color : '#9a9cae'}};
        }

            /* sub manu active*/
            #kt_app_sidebar .menu-sub .menu-item .menu-link.active:hover {
                border-radius:  0.475rem;
                margin-right: 0rem !important;
            }
            [data-kt-app-layout=dark-sidebar] .app-sidebar .menu .menu-item .menu-link:hover {
                transition: color .2s ease;
                background-color: {{isset($branding_details->hover_color) ? $branding_details->hover_color : '#f5f5f5'}} !important;
                color:{{isset($branding_details->sidebar_menu_font_color) ? $branding_details->sidebar_menu_font_color : '#9a9cae'}} !important;
            }

            /* Active state for menu items */
            [data-kt-app-layout=dark-sidebar] .app-sidebar .menu .menu-item .menu-link.active {
                transition: color .2s ease;
                background-color: {{isset($branding_details->sidebar_active_color) ? $branding_details->sidebar_active_color : '#1c1c21'}} !important;
                /* font-weight: bold; */
            }

            [data-kt-app-layout=dark-sidebar] .app-sidebar .menu .menu-item .menu-link.active .menu-title {
                color:  {{isset($branding_details->sidebar_active_font_color) ? $branding_details->sidebar_active_font_color : '#9a9cae'}} !important;
                /* font-weight:bold; */
            }
            /* sub manu */
        /* end Special hover state for active menu items */

        #kt_app_header{
            top: 1px; background: #FCFCFC; border-bottom:1px dashed {{isset($branding_details->sidebar_color) ? $branding_details->sidebar_color : '#000000'}};
        }

        .btn.btn-primary {
            color: {{isset($branding_details->primary_color_text) ? $branding_details->primary_color_text : '#000000'}};
            border-color: {{ isset($branding_details->primary_color) ? $branding_details->primary_color : '#D2671F' }};
            background-color: {{ isset($branding_details->primary_color) ? $branding_details->primary_color : '#D2671F' }};
        }

        .btn.btn-primary .svg-icon, .btn.btn-primary i {
            color: {{ $branding_details->primary_color_text }};
        }

        /* aa */
        .bg-primary-color{
            background-color: {{ isset($branding_details->primary_color) ? $branding_details->primary_color : '#D2671F' }} !important;
        }
        .text-primary-color{
            color: {{ isset($branding_details->primary_color_text) ? $branding_details->primary_color_text : '#D2671F' }} !important;
        }
        .bg-secondary-color{
            background-color: {{ $branding_details->secondary_color }} ;
        }
        .text-secondary-color{
            color: {{ $branding_details->secondary_color_text }} ;
        }
        .bg-tertiary-color{
            background-color: {{ $branding_details->tertiary_color }} ;
        }
        .text-tertiary-color{
            color: {{ $branding_details->tertiary_color_text }} ;
        }
        .bg-sidebar-color{
            background-color: {{ $branding_details->sidebar_color }} ;
        }
        .bg-sidebar-active-color{
            background-color: {{ $branding_details->sidebar_active_color }} !important;
        }
        .text-sidebar-active-color{
            color: {{ $branding_details->sidebar_active_font_color }} !important;
        }
        .text-sidebar-color{
            color: {{ $branding_details->sidebar_menu_font_color }};
        }

        .hover-statistic-card {
            transition: background-color .2s ease, color .2s ease;
            background-color: {{ $branding_details->secondary_color }};
            color: {{ $branding_details->secondary_color_text }};
        }
        .hover-statistic-card:hover {
            background-color: {{ $branding_details->hover_color }} !important;
            color: {{ $branding_details->secondary_color_text }} !important;
        }

        /* sidebar active menu-arrow color */
        [data-kt-app-layout=dark-sidebar] .app-sidebar .menu .menu-item .menu-link .menu-arrow:after {
            background-color:  {{isset($branding_details->sidebar_menu_font_color) ? $branding_details->sidebar_menu_font_color : '#9a9cae'}} !important;
        }

        /* sidebar active colr */
        [data-kt-app-layout=dark-sidebar] .app-sidebar .menu .menu-item.here>.menu-link .menu-arrow:after {
            background-color:  {{isset($branding_details->sidebar_menu_font_color) ? $branding_details->sidebar_menu_font_color : '#9a9cae'}} !important;
        }

        [data-kt-app-layout=dark-sidebar] .app-sidebar .menu .menu-item.show>.menu-link .menu-arrow:after {
            background-color:  {{isset($branding_details->sidebar_active_font_color) ? $branding_details->sidebar_active_font_color : '#9a9cae'}} !important;
        }

        [data-kt-app-layout=dark-sidebar] .app-sidebar .menu .menu-item.hover:not(.here)>.menu-link:not(.disabled):not(.active):not(.here) .menu-arrow:after,[data-kt-app-layout=dark-sidebar] .app-sidebar .menu .menu-item:not(.here) .menu-link:hover:not(.disabled):not(.active):not(.here) .menu-arrow:after {
            background-color:  {{isset($branding_details->sidebar_menu_font_color) ? $branding_details->sidebar_menu_font_color : '#9a9cae'}} !important;
        }

        [data-kt-app-layout=dark-sidebar] .app-sidebar .menu .menu-item .menu-link.active .menu-arrow:after {
            background-color:  {{isset($branding_details->sidebar_active_font_color) ? $branding_details->sidebar_active_font_color : '#9a9cae'}} !important;
        }


        /* Default sidebar SVG color */
        [data-kt-app-layout=dark-sidebar] .app-sidebar .menu .menu-item .menu-link .menu-icon svg {
            fill: {{ isset($branding_details->sidebar_menu_font_color) ? $branding_details->sidebar_menu_font_color : '#9a9cae' }} !important;
        }

        /* SVG color for active (here) menu items */
        [data-kt-app-layout=dark-sidebar] .app-sidebar .menu .menu-item.here>.menu-link .menu-icon svg,
        [data-kt-app-layout=dark-sidebar] .app-sidebar .menu .menu-item.show>.menu-link .menu-icon svg,
        [data-kt-app-layout=dark-sidebar] .app-sidebar .menu .menu-item.active>.menu-link .menu-icon svg {
            fill: {{ isset($branding_details->sidebar_active_font_color) ? $branding_details->sidebar_active_font_color : '#9a9cae' }} !important;
        }

        /* SVG color on hover for non-active items */
        [data-kt-app-layout=dark-sidebar] .app-sidebar .menu .menu-item.hover:not(.here)>.menu-link .menu-icon svg,
        [data-kt-app-layout=dark-sidebar] .app-sidebar .menu .menu-item:not(.here) .menu-link:hover .menu-icon svg {
            fill: {{ isset($branding_details->sidebar_menu_font_color) ? $branding_details->sidebar_menu_font_color : '#9a9cae' }} !important;
        }

        /* SVG color for disabled or inactive menu items */
        [data-kt-app-layout=dark-sidebar] .app-sidebar .menu .menu-item .menu-link.disabled .menu-icon svg,
        [data-kt-app-layout=dark-sidebar] .app-sidebar .menu .menu-item:not(.here) .menu-link:not(.active):not(.hover) .menu-icon svg {
            fill: {{ isset($branding_details->sidebar_menu_font_color) ? $branding_details->sidebar_menu_font_color : '#9a9cae' }} !important;
        }
         /* i icon main menu */
        [data-kt-app-layout="dark-sidebar"] .app-sidebar .menu .menu-item .menu-link.active .menu-icon i {
            color: {{ $branding_details->sidebar_active_font_color }} !important;
        }
        [data-kt-app-layout="dark-sidebar"] .app-sidebar .menu .menu-item .menu-link .menu-icon i {
            color: {{ $branding_details->sidebar_menu_font_color }} !important;
        }
        [data-kt-app-layout=dark-sidebar] .app-sidebar .menu .menu-item.show>.menu-link .menu-icon, [data-kt-app-layout=dark-sidebar] .app-sidebar .menu .menu-item.show>.menu-link .menu-icon .svg-icon, [data-kt-app-layout=dark-sidebar] .app-sidebar .menu .menu-item.show>.menu-link .menu-icon i {
            color: {{ $branding_details->sidebar_active_font_color }} !important;
        }
/*  */
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
