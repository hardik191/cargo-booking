@php
    $currentRoute = Route::current()->getName();
    $get_system_setting = get_system_setting('general_setting');
    $general_setting_details = json_decode($get_system_setting['value']);
    $get_system_setting_branding = get_system_setting('branding');
    $branding_setting_details = json_decode($get_system_setting_branding['value']);

    $auth_user = Auth::user();

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
                    <a class="menu-link {{ in_array($currentRoute, ['dashboard1']) ? 'active' : '' }}"
                        href="{{route('dashboard1')}}">
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

                <div class="menu-item pt-3">
                    <div class="menu-content">
                        <span class="menu-heading fw-bold text-uppercase fs-7">ORDER Management</span>
                    </div>
                </div>
             
                    <div data-kt-menu-trigger="click" class="menu-item menu-accordion {{ (in_array($currentRoute, ['create-order', 'edit-order', 'pending-order1', 'view-pending-order1', 'accepted-order1', 'view-accepted-order1', 'shipped-order1', 'view-shipped-order1', 'delivery-order1', 'view-delivery-order1', 'rejected-order1', 'view-rejected-order1' ]) ? 'here show' : '' ) }}">
                        <span class="menu-link">
                            <span class="menu-icon">
                                <i class="ki-duotone ki-abstract-13 fs-2">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                            </span>
                            <span class="menu-title">ORDER Management</span>
                            <span class="menu-arrow"></span>
                        </span>
                        <div class="menu-sub menu-sub-accordion">

                            {{-- @if (Auth::user()->can('service-management dashboard') || Auth::user()->can('service-management own-dashboard')) --}}
                                <div class="menu-item">
                                    <a class="menu-link {{ ( in_array($currentRoute, ['create-order']) ? 'active' : '' ) }}" href="{{route('create-order')}}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">Create Order</span>
                                    </a>
                                </div>
                            {{-- @endif --}}
                        
                                <div class="menu-item">
                                    <a class="menu-link {{ ( in_array($currentRoute, ['pending-order1', 'edit-order', 'view-pending-order1', ]) ? 'active' : '' ) }}" href="{{route('pending-order1')}}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">Pending Order</span>
                                    </a>
                                </div>

                                <div class="menu-item">
                                    <a class="menu-link {{ ( in_array($currentRoute, ['accepted-order1', 'view-accepted-order1', ]) ? 'active' : '' ) }}" href="{{route('accepted-order1')}}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">Accepted Order</span>
                                    </a>
                                </div>

                                <div class="menu-item">
                                    <a class="menu-link {{ ( in_array($currentRoute, ['shipped-order1', 'view-shipped-order1', ]) ? 'active' : '' ) }}" href="{{route('shipped-order1')}}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">Shipped Order</span>
                                    </a>
                                </div>

                                <div class="menu-item">
                                    <a class="menu-link {{ ( in_array($currentRoute, ['delivery-order1', 'view-delivery-order1', ]) ? 'active' : '' ) }}" href="{{route('delivery-order1')}}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">Delivery Order</span>
                                    </a>
                                </div>

                                <div class="menu-item">
                                    <a class="menu-link {{ ( in_array($currentRoute, ['rejected-order1', 'view-rejected-order1']) ? 'active' : '' ) }}" href="{{route('rejected-order1')}}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">Rejected Order</span>
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
