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
                    <a class="menu-link {{ in_array($currentRoute, ['dashboard']) ? 'active' : '' }}"
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

                {{-- User Management --}}
                @canany(['role list', 'permission list', 'customer list', 'admin list'])
                    <div data-kt-menu-trigger="click" class="menu-item menu-accordion {{ in_array($currentRoute, ['permissions', 'roles', 'customer-list', 'admin-list', 'add-admin', 'edit-admin']) ? 'here show' : '' }}" >
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

                            @can('role list')
                                <div class="menu-item">
                                    <a class="menu-link {{ in_array($currentRoute, ['roles']) ? 'active' : '' }}" href="{{route('roles')}}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">Role</span>
                                    </a>
                                </div>
                            @endcan

                            @can('permission list')
                                <div class="menu-item">
                                    <a class="menu-link {{ in_array($currentRoute, ['permissions']) ? 'active' : '' }}" href="{{route('permissions')}}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">Permissions</span>
                                    </a>
                                </div>
                            @endcan

                            @can('customer list')
                                <div class="menu-item">
                                    <a class="menu-link {{ in_array($currentRoute, ['customer-list']) ? 'active' : '' }}" href="{{route('customer-list')}}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">Customer</span>
                                    </a>
                                </div>
                            @endcan

                            @can('admin list')
                                <div class="menu-item">
                                    <a class="menu-link {{ in_array($currentRoute, ['admin-list', 'add-admin', 'edit-admin']) ? 'active' : '' }}" href="{{route('admin-list')}}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">Admin</span>
                                    </a>
                                </div>
                            @endcan
                        </div>
                    </div>
                @endcanany

                {{-- Master --}}
                @canany(['port list', 'order-charge list', 'container list'])
                    <div data-kt-menu-trigger="click" class="menu-item menu-accordion {{ in_array($currentRoute, ['port-list', 'order-charge-list', 'container-list']) ? 'here show' : '' }}" >
                        <span class="menu-link">
                            <span class="menu-icon">
                                <i class="ki-duotone ki-address-book fs-2">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                    <span class="path3"></span>
                                </i>
                            </span>
                            <span class="menu-title">Master Management</span>
                            <span class="menu-arrow"></span>
                        </span>
                        <div class="menu-sub menu-sub-accordion">

                            @can('port list')
                                <div class="menu-item">
                                    <a class="menu-link {{ in_array($currentRoute, ['port-list']) ? 'active' : '' }}" href="{{route('port-list')}}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">Port</span>
                                    </a>
                                </div>
                            @endcan

                            @can('container list')
                                <div class="menu-item">
                                    <a class="menu-link {{ in_array($currentRoute, ['container-list']) ? 'active' : '' }}" href="{{route('container-list')}}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">Container</span>
                                    </a>
                                </div>
                            @endcan

                            @can('order-charge list')
                                <div class="menu-item">
                                    <a class="menu-link {{ in_array($currentRoute, ['order-charge-list']) ? 'active' : '' }}" href="{{route('order-charge-list')}}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">Order Charge</span>
                                    </a>
                                </div>
                            @endcan

                        </div>
                    </div>
                @endcanany

                @canany(['pending-order list', 'accepted-order list', 'rejected-order list', 'shipped-order list', 'delivery-order list'])
                    <div data-kt-menu-trigger="click" class="menu-item menu-accordion {{ (in_array($currentRoute, ['pending-order', 'view-pending-order', 'accepted-order', 'view-accepted-order', 'shipped-order', 'view-shipped-order', 'delivery-order', 'view-delivery-order', 'rejected-order', 'view-rejected-order' ]) ? 'here show' : '' ) }}">
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
                            @can('pending-order list')
                                <div class="menu-item">
                                    <a class="menu-link {{ ( in_array($currentRoute, ['pending-order', 'edit-order', 'view-pending-order', ]) ? 'active' : '' ) }}" href="{{route('pending-order')}}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">Pending Order</span>
                                    </a>
                                </div>
                            @endcan

                            @can('accepted-order list')
                                <div class="menu-item">
                                    <a class="menu-link {{ ( in_array($currentRoute, ['accepted-order', 'view-accepted-order', ]) ? 'active' : '' ) }}" href="{{route('accepted-order')}}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">Accepted Order</span>
                                    </a>
                                </div>
                            @endcan
                            
                            @can('shipped-order list')
                                <div class="menu-item">
                                    <a class="menu-link {{ ( in_array($currentRoute, ['shipped-order', 'view-shipped-order', ]) ? 'active' : '' ) }}" href="{{route('shipped-order')}}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">Shipped Order</span>
                                    </a>
                                </div>
                            @endcan

                            @can('delivery-order list')
                                <div class="menu-item">
                                    <a class="menu-link {{ ( in_array($currentRoute, ['delivery-order', 'view-delivery-order', ]) ? 'active' : '' ) }}" href="{{route('delivery-order')}}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">Delivery Order</span>
                                    </a>
                                </div>
                            @endcan

                            @can('rejected-order list')
                                <div class="menu-item">
                                    <a class="menu-link {{ ( in_array($currentRoute, ['rejected-order', 'view-rejected-order']) ? 'active' : '' ) }}" href="{{route('rejected-order')}}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">Rejected Order</span>
                                    </a>
                                </div>
                            @endcan
                            
                        </div>
                    </div>
                @endcanany
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
