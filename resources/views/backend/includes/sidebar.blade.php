@php
$currentRoute = Route::current()->getName();
$get_system_setting = get_system_setting('general_setting');
$general_setting_details = json_decode($get_system_setting['value']);
$get_system_setting_branding = get_system_setting('branding');
$branding_setting_details = json_decode($get_system_setting_branding['value']);


@endphp
<div id="kt_app_sidebar" class="app-sidebar flex-column" data-kt-drawer="true"
data-kt-drawer-name="app-sidebar" data-kt-drawer-activate="{default: true, lg: false}"
data-kt-drawer-overlay="true" data-kt-drawer-width="225px" data-kt-drawer-direction="start"
data-kt-drawer-toggle="#kt_app_sidebar_mobile_toggle">
<div class="app-sidebar-logo px-6" id="kt_app_sidebar_logo">
    <div class="hide-on-toggle">
        <h3 style="color: {{isset($branding_setting_details->sidebar_menu_font_color) ? $branding_setting_details->sidebar_menu_font_color : '#9a9cae'}}">{{isset($general_setting_details->sidebar_navbar_name) ? $general_setting_details->sidebar_navbar_name : ''}}</h3>
    </div>


    <div id="kt_app_sidebar_toggle"
        class="app-sidebar-toggle btn btn-icon btn-shadow btn-sm btn-color-muted btn-active-color-primary h-30px w-30px position-absolute top-50 start-100 translate-middle rotate"
        data-kt-toggle="true" data-kt-toggle-state="active" data-kt-toggle-target="body"
        data-kt-toggle-name="app-sidebar-minimize">
        <i class="ki-duotone ki-black-left-line fs-3 rotate-180">
            <span class="path1"></span>
            <span class="path2"></span>
        </i>
    </div>
</div>
<div class="app-sidebar-menu overflow-hidden flex-column-fluid">
    <div id="kt_app_sidebar_menu_wrapper" class="app-sidebar-wrapper">
        <div id="kt_app_sidebar_menu_scroll" class="scroll-y my-5 mx-3" data-kt-scroll="true"
            data-kt-scroll-activate="true" data-kt-scroll-height="auto"
            data-kt-scroll-dependencies="#kt_app_sidebar_logo, #kt_app_sidebar_footer"
            data-kt-scroll-wrappers="#kt_app_sidebar_menu" data-kt-scroll-offset="5px"
            data-kt-scroll-save-state="true">
            <div class="menu menu-column menu-rounded menu-sub-indention fw-semibold fs-6"
                id="#kt_app_sidebar_menu" data-kt-menu="true" data-kt-menu-expand="false">
                <div class="menu-item">
                    <a class="menu-link {{ (  $currentRoute  ==  "dashboard" ? 'active' : '' ) }}"
                        href="{{route('dashboard')}}">
                        <span class="menu-icon">
                            <i class="ki-duotone ki-element-11 fs-2">
                                <span class="path1"></span>
                                <span class="path2"></span>
                                <span class="path3"></span>
                                <span class="path4"></span>
                            </i>
                        </span>
                        <span class="menu-title">Dashboard</span>
                    </a>
                </div>

                    <div data-kt-menu-trigger="click" class="menu-item menu-accordion {{ (  $currentRoute  ==  "permissions" || $currentRoute  ==  "roles" ? 'here show' : '' ) }}">
                        <span class="menu-link">
                            <span class="menu-icon">
                                <i class="ki-duotone ki-address-book fs-2">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                    <span class="path3"></span>
                                </i>
                            </span>
                            <span class="menu-title">User Management</span>
                            <span class="menu-arrow"></span>
                        </span>
                        <div class="menu-sub menu-sub-accordion">
                            <div class="menu-item">
                                <a class="menu-link {{ (  $currentRoute  ==  "roles" ? 'active' : '' ) }}" href="{{route('roles')}}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">Role</span>
                                </a>
                            </div>

                            <div class="menu-item">
                                <a class="menu-link {{ (  $currentRoute  ==  "permissions" ? 'active' : '' ) }}" href="{{route('permissions')}}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">Permissions</span>
                                </a>
                            </div>

                        </div>
                    </div>

                    <div data-kt-menu-trigger="click" class="menu-item menu-accordion {{ (  $currentRoute  ==  "permissions" || $currentRoute  ==  "roles" ? 'here show' : '' ) }}">
                        <span class="menu-link">
                            <span class="menu-icon">
                                <i class="ki-duotone ki-address-book fs-2">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                    <span class="path3"></span>
                                </i>
                            </span>
                            <span class="menu-title">Order Management</span>
                            <span class="menu-arrow"></span>
                        </span>
                        <div class="menu-sub menu-sub-accordion">
                            <div class="menu-item">
                                <a class="menu-link {{ (  $currentRoute  ==  "roles" ? 'active' : '' ) }}" href="{{route('roles')}}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">Pending </span>
                                </a>
                            </div>

                            <div class="menu-item">
                                <a class="menu-link {{ (  $currentRoute  ==  "permissions" ? 'active' : '' ) }}" href="{{route('permissions')}}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">Permissions</span>
                                </a>
                            </div>

                        </div>
                    </div>

            </div>
        </div>
    </div>
</div>

</div>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<script>
    $("#kt_app_sidebar_toggle").on("click", function () {

        var isButtonActive = $(this).hasClass("active");

    if (isButtonActive) {
        $('.hide-on-toggle').show();
    } else {
        $('.hide-on-toggle').hide();
    }

});
</script>
