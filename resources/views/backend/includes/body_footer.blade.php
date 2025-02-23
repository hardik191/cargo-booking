@php
    $get_system_setting = get_system_setting('general_setting');
$general_setting_details = json_decode($get_system_setting['value']);
@endphp
<div id="kt_app_footer" class="app-footer" style="background: whitesmoke;">
    <!--begin::Footer container-->
    <div
        class="app-container container-fluid d-flex flex-column flex-md-row flex-center flex-md-stack py-3">
        <!--begin::Copyright-->
        <div class="text-gray-900 order-2 order-md-1">
            {{-- <span class="text-muted fw-semibold me-1">{{ date('Y') }}&copy;</span> --}}
            <a href="{{ isset($general_setting_details->footer_link) ? $general_setting_details->footer_link : 'javascript:;' }}" target="_black" class="text-gray-800 text-hover-primary">{{ isset($general_setting_details->footer_text) ? $general_setting_details->footer_text : '' }}</a>
        </div>
        <!--end::Copyright-->

    </div>
    <!--end::Footer container-->
</div>
