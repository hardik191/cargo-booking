@extends('backend.layout.layout')
@section('content')

@php


$data = Auth()->user();


if($data['user_image'] != '' || $data['user_image'] != null ){
    $image = url("backend/upload/userprofile/".$data['user_image']);
}else{
    $image = url("backend/upload/userprofile/default.jpg");
}

// ccd('hi');
@endphp

<div class="row gy-5 gx-xl-10">
    <!--begin::Col-->
    <div class="col-xl-12 mb-xl-10">
        <div class="card mb-5 mb-xl-10">
            <!--begin::Card header-->
            <div class="card-header border-0 cursor-pointer" >
                <!--begin::Card title-->
                <div class="card-title m-0">
                    <h3 class="fw-bold m-0">{{$header['title']}}</h3>
                </div>
                <!--end::Card title-->
            </div>
            <!--begin::Card header-->
            <!--begin::Content-->
            <div id="kt_account_settings_profile_details" class="collapse show">
                <!--begin::Form-->
                <div class="rounded border p-10">
                    <div class="mb-5 hover-scroll-x">
                        <div class="d-grid">
                            <ul class="nav nav-tabs flex-nowrap text-nowrap" role="tablist">
                                @can('setting general-setting')
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link btn btn-active-light btn-color-gray-600 btn-active-color-primary rounded-bottom-0 active" data-bs-toggle="tab" href="#kt_tab_pane_1" aria-selected="true" role="tab">General Setting</a>
                                    </li>
                                @endcan
                                @can('setting branding-setting')
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link btn btn-active-light btn-color-gray-600 btn-active-color-primary rounded-bottom-0" data-bs-toggle="tab" href="#kt_tab_pane_2" aria-selected="false" role="tab" tabindex="-1">Branding</a>
                                    </li>
                                @endcan

                                @can('system-setting email setting')
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link btn btn-active-light btn-color-gray-600 btn-active-color-primary rounded-bottom-0" data-bs-toggle="tab" href="#kt_tab_pane_3" aria-selected="true" role="tab">Email Setting</a>
                                    </li>
                                @endcan

                                @can('system-setting sms/Whatsapp setting')
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link btn btn-active-light btn-color-gray-600 btn-active-color-primary rounded-bottom-0" data-bs-toggle="tab" href="#kt_tab_pane_4" aria-selected="true" role="tab">SMS/WhatsApp Setting
                                        </a>
                                    </li>
                                @endcan
                            </ul>
                        </div>
                    </div>

                    <div class="tab-content" id="myTabContent">
                        @can('setting general-setting')
                        <div class="tab-pane fade show active" id="kt_tab_pane_1" role="tabpanel">
                            <form id="general-setting" class="form fv-plugins-bootstrap5 fv-plugins-framework" method="POST" action="{{route('save-system-setting')}}">
                                @csrf
                                <!--begin::Card body-->
                                @php
                                    $get_system_setting = get_system_setting('general_setting');
                                    $general_setting_details = json_decode($get_system_setting['value']);
                                @endphp
                                <div class="card-body">

                                    <div class="row mb-5">

                                            <div class="col-md-12 fv-row fv-plugins-icon-container">

                                                <label class="required fs-5 fw-semibold mb-2"> System Name</label>

                                                <input type="text" class="form-control" placeholder="Please enter system name" name="system_name" value="{{isset($general_setting_details->system_name) ? $general_setting_details->system_name : old('system_name')}}">

                                                @error('system_name')
                                                    <div class="alert alert-danger">{{ $message }}</div>
                                                @enderror
                                            </div>


                                    </div>

                                    <div class="row mb-5">



                                        <div class="col-md-6 fv-row fv-plugins-icon-container">

                                            <label class="required fs-5 fw-semibold mb-2"> Footer Text</label>

                                            <input type="text" class="form-control" placeholder="Please enter footer text" name="footer_text" value="{{isset($general_setting_details->footer_text) ? $general_setting_details->footer_text : old('footer_text') }}">
                                            @error('footer_text')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror

                                        </div>

                                        <div class="col-md-6 fv-row fv-plugins-icon-container">

                                            <label class="fs-5 fw-semibold mb-2">Footer Link</label>

                                            <input type="text" class="form-control" placeholder="Please enter system name" name="footer_link" value="{{isset($general_setting_details->footer_link) ? $general_setting_details->footer_link : old('footer_link') }}">
                                            @error('footer_link')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror

                                        </div>
                                </div>

                                <div class="row mb-5">



                                    <div class="col-md-6 fv-row fv-plugins-icon-container">

                                        <label class="required fs-5 fw-semibold mb-2"> Sidebar Navbar Name</label>

                                        <input type="text" class="form-control " placeholder="Please enter sidebar navbar name" name="sidebar_navbar_name" value="{{isset($general_setting_details->sidebar_navbar_name) ? $general_setting_details->sidebar_navbar_name : old('sidebar_navbar_name') }}">

                                        @error('sidebar_navbar_name')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    {{-- <div class="col-md-6 fv-row fv-plugins-icon-container">

                                        <label class="required fs-5 fw-semibold mb-2">Header Navbar Name</label>

                                        <input type="text" class="form-control " placeholder="Please enter header navbar name" name="header_navbar_name" value="{{isset($general_setting_details->header_navbar_name) ? $general_setting_details->header_navbar_name : old('header_navbar_name') }}">
                                        @error('header_navbar_name')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div> --}}
                                    <input type="hidden" name="key" value="general_setting">

                                </div>
                                    </div>
                                    <!--end::Card body-->
                                    <!--begin::Actions-->
                                    <div class="card-footer d-flex justify-content-end py-6 px-9">
                                        <button type="reset" class="btn btn-secondary me-2">Discard</button>
                                        <button type="submit" class="btn btn-primary submitbtn">
                                            <span class="indicator-label">Save Changes</span>
                                            <span class="indicator-progress">Please wait...
                                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                        </button>
                                    </div>
                                    <!--end::Actions-->
                                <input type="hidden">
                            </form>
                        </div>
                        @endcan

                        @can('setting branding-setting')
                            <div class="tab-pane fade" id="kt_tab_pane_2" role="tabpanel">
                                <form id="branding-setting" class="form fv-plugins-bootstrap5 fv-plugins-framework" method="POST" action="{{route('save-system-setting')}}">
                                    @csrf

                                    @php
                                        $get_system_setting = get_system_setting('branding');
                                        $branding_details = json_decode($get_system_setting['value']);
                                    @endphp
                                    <!--begin::Card body-->
                                    <div class="card-body">

                                        <div class="row mb-5">
                                                <div class="col-md-6 fv-row fv-plugins-icon-container">
                                                    <label class="fs-5 fw-semibold mb-2"> Primary Color</label>
                                                    <input type="color" class="form-control" name="primary_color" value="{{isset($branding_details->primary_color) ? $branding_details->primary_color : '' }}">
                                                </div>

                                                <div class="col-md-6 fv-row fv-plugins-icon-container">
                                                    <label class="fs-5 fw-semibold mb-2"> Primary Color Text</label>
                                                    <input type="color" class="form-control" name="primary_color_text" value="{{isset($branding_details->primary_color_text) ? $branding_details->primary_color_text : '' }}">
                                                </div>

                                            <input type="hidden" name="key" value="branding">

                                        </div>


                                        <div class="row mb-5">
                                            <div class="col-md-6 fv-row fv-plugins-icon-container">
                                                <label class="fs-5 fw-semibold mb-2"> Secondary Color</label>
                                                <input type="color" class="form-control" name="secondary_color" value="{{isset($branding_details->secondary_color) ? $branding_details->secondary_color : '' }}">
                                            </div>

                                            <div class="col-md-6 fv-row fv-plugins-icon-container">
                                                <label class="fs-5 fw-semibold mb-2"> Secondary Color Text</label>
                                                <input type="color" class="form-control" name="secondary_color_text" value="{{isset($branding_details->secondary_color_text) ? $branding_details->secondary_color_text : '' }}">
                                            </div>
                                        </div>

                                        <div class="row mb-5">
                                            <div class="col-md-6 fv-row fv-plugins-icon-container">
                                                <label class="fs-5 fw-semibold mb-2"> Tertiary Color</label>
                                                <input type="color" class="form-control" name="tertiary_color" value="{{isset($branding_details->tertiary_color) ? $branding_details->tertiary_color : '' }}">
                                            </div>

                                            <div class="col-md-6 fv-row fv-plugins-icon-container">
                                                <label class="fs-5 fw-semibold mb-2"> Tertiary Color Text</label>
                                                <input type="color" class="form-control" name="tertiary_color_text" value="{{isset($branding_details->tertiary_color_text) ? $branding_details->tertiary_color_text : '' }}">
                                            </div>
                                        </div>

                                        <div class="row mb-5">
                                            <div class="col-md-6 fv-row fv-plugins-icon-container">
                                                <label class="fs-5 fw-semibold mb-2">Table Color</label>
                                                <input type="color" class="form-control" name="table_color" value="{{isset($branding_details->table_color) ? $branding_details->table_color : '' }}">
                                            </div>

                                            <div class="col-md-6 fv-row fv-plugins-icon-container">
                                                <label class="fs-5 fw-semibold mb-2">Table Color Text</label>
                                                <input type="color" class="form-control" name="table_color_text" value="{{isset($branding_details->table_color_text) ? $branding_details->table_color_text : '' }}">
                                            </div>
                                        </div>

                                        <div class="row mb-5">
                                            <div class="col-md-6 fv-row fv-plugins-icon-container">
                                                <label class="fs-5 fw-semibold mb-2">Card Color</label>
                                                <input type="color" class="form-control" name="card_color" value="{{isset($branding_details->card_color) ? $branding_details->card_color : '' }}">
                                            </div>

                                            <div class="col-md-6 fv-row fv-plugins-icon-container">
                                                <label class="fs-5 fw-semibold mb-2">Card Color Text</label>
                                                <input type="color" class="form-control" name="card_color_text" value="{{isset($branding_details->card_color_text) ? $branding_details->card_color_text : '' }}">
                                            </div>
                                        </div>

                                        <div class="row mb-5">
                                            <div class="col-md-6 fv-row fv-plugins-icon-container">
                                                <label class="fs-5 fw-semibold mb-2"> Sidebar Color</label>
                                                <input type="color" class="form-control" name="sidebar_color" value="{{isset($branding_details->sidebar_color) ? $branding_details->sidebar_color : '' }}">
                                            </div>

                                            <div class="col-md-6 fv-row fv-plugins-icon-container">
                                                <label class="fs-5 fw-semibold mb-2"> Sidebar Menu Font Color</label>
                                                <input type="color" class="form-control" name="sidebar_menu_font_color" value="{{isset($branding_details->sidebar_menu_font_color) ? $branding_details->sidebar_menu_font_color : '' }}">
                                            </div>
                                        </div>

                                        <div class="row mb-5">
                                            <div class="col-md-6 fv-row fv-plugins-icon-container">
                                                <label class="fs-5 fw-semibold mb-2"> Sidebar Active Color</label>
                                                <input type="color" class="form-control" name="sidebar_active_color" value="{{isset($branding_details->sidebar_active_color) ? $branding_details->sidebar_active_color : '' }}">
                                            </div>

                                            <div class="col-md-6 fv-row fv-plugins-icon-container">
                                                <label class="fs-5 fw-semibold mb-2"> Sidebar Active Font Color</label>
                                                <input type="color" class="form-control" name="sidebar_active_font_color" value="{{isset($branding_details->sidebar_active_font_color) ? $branding_details->sidebar_active_font_color : '' }}">
                                            </div>
                                        </div>

                                        <div class="row mb-5">
                                            <div class="col-md-6 fv-row fv-plugins-icon-container">
                                                <label class="fs-5 fw-semibold mb-2"> Hover Color</label>
                                                <input type="color" class="form-control" name="hover_color" value="{{isset($branding_details->hover_color) ? $branding_details->hover_color : '' }}">
                                            </div>

                                            <div class="col-md-6 fv-row fv-plugins-icon-container">
                                                <label class="fs-5 fw-semibold mb-2"> Hover Font Color</label>
                                                <input type="color" class="form-control" name="hover_font_color" value="{{isset($branding_details->hover_font_color) ? $branding_details->hover_font_color : '' }}">
                                            </div>
                                        </div>
                                        <div class="row mb-5">
                                            <div class="col-md-3 fv-row fv-plugins-icon-container">
                                                <label class=" col-form-label fw-semibold fs-6">Favicon Icon</label>
                                                <!--end::Label-->
                                                <!--begin::Col-->
                                                @php
                                                    if(isset($branding_details->favicon_icon_name) ){
                                                        $favicon_icon = url("backend/upload/system_setting/".$branding_details->favicon_icon_name);
                                                    }else{
                                                        $favicon_icon = url("backend/upload/system_setting/default_no_image.png");
                                                    }
                                                @endphp
                                                <div class="">
                                                    <!--begin::Image input-->
                                                    <div class="image-input image-input-outline" data-kt-image-input="true" style="background-image: url('assets/media/svg/avatars/blank.svg')">
                                                        <!--begin::Preview existing avatar-->
                                                        <div class="image-input-wrapper w-125px h-125px" style="background-image: url({{$favicon_icon}})"></div>
                                                        <!--end::Preview existing avatar-->
                                                        <!--begin::Label-->
                                                        <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" aria-label="Change avatar" data-bs-original-title="Change avatar" data-kt-initialized="1">
                                                            <i class="ki-duotone ki-pencil fs-7">
                                                                <span class="path1"></span>
                                                                <span class="path2"></span>
                                                            </i>
                                                            <!--begin::Inputs-->
                                                            <input type="file" name="favicon_icon" accept=".png, .jpg, .jpeg">
                                                            <input type="hidden" name="avatar_remove">
                                                            <!--end::Inputs-->
                                                        </label>
                                                        <!--end::Label-->
                                                        <!--begin::Cancel-->
                                                        <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="cancel" data-bs-toggle="tooltip" aria-label="Cancel avatar" data-bs-original-title="Cancel avatar" data-kt-initialized="1">
                                                            <i class="ki-duotone ki-cross fs-2">
                                                                <span class="path1"></span>
                                                                <span class="path2"></span>
                                                            </i>
                                                        </span>
                                                        <!--end::Cancel-->
                                                        <!--begin::Remove-->
                                                        <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="remove" data-bs-toggle="tooltip" aria-label="Remove avatar" data-bs-original-title="Remove avatar" data-kt-initialized="1">
                                                            <i class="ki-duotone ki-cross fs-2">
                                                                <span class="path1"></span>
                                                                <span class="path2"></span>
                                                            </i>
                                                        </span>
                                                        <!--end::Remove-->
                                                    </div>
                                                    <!--end::Image input-->
                                                    <!--begin::Hint-->
                                                    <div class="form-text">Allowed file types: png, jpg, jpeg.</div>
                                                    <!--end::Hint-->
                                                </div>
                                                    <!--end::Input-->
                                                <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
                                            </div>

                                            <div class="col-md-3 fv-row fv-plugins-icon-container">
                                                <label class=" col-form-label fw-semibold fs-6">Login Icon</label>
                                                <!--end::Label-->
                                                <!--begin::Col-->
                                                <div class="">
                                                    @php
                                                        if(isset($branding_details->login_icon_name) ){
                                                            $login_icon = url("backend/upload/system_setting/".$branding_details->login_icon_name);
                                                        }else{
                                                            $login_icon = url("backend/upload/system_setting/default_no_image.png");
                                                        }
                                                    @endphp

                                                    <!--begin::Image input-->
                                                    <div class="image-input image-input-outline" data-kt-image-input="true" style="background-image: url('assets/media/svg/avatars/blank.svg')">
                                                        <!--begin::Preview existing avatar-->
                                                        <div class="image-input-wrapper w-125px h-125px" style="background-image: url({{ $login_icon }})"></div>
                                                        <!--end::Preview existing avatar-->
                                                        <!--begin::Label-->
                                                        <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" aria-label="Change avatar" data-bs-original-title="Change avatar" data-kt-initialized="1">
                                                            <i class="ki-duotone ki-pencil fs-7">
                                                                <span class="path1"></span>
                                                                <span class="path2"></span>
                                                            </i>
                                                            <!--begin::Inputs-->
                                                            <input type="file" name="login_icon" accept=".png, .jpg, .jpeg">
                                                            <input type="hidden" name="avatar_remove">
                                                            <!--end::Inputs-->
                                                        </label>
                                                        <!--end::Label-->
                                                        <!--begin::Cancel-->
                                                        <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="cancel" data-bs-toggle="tooltip" aria-label="Cancel avatar" data-bs-original-title="Cancel avatar" data-kt-initialized="1">
                                                            <i class="ki-duotone ki-cross fs-2">
                                                                <span class="path1"></span>
                                                                <span class="path2"></span>
                                                            </i>
                                                        </span>
                                                        <!--end::Cancel-->
                                                        <!--begin::Remove-->
                                                        <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="remove" data-bs-toggle="tooltip" aria-label="Remove avatar" data-bs-original-title="Remove avatar" data-kt-initialized="1">
                                                            <i class="ki-duotone ki-cross fs-2">
                                                                <span class="path1"></span>
                                                                <span class="path2"></span>
                                                            </i>
                                                        </span>
                                                        <!--end::Remove-->
                                                    </div>
                                                    <!--end::Image input-->
                                                    <!--begin::Hint-->
                                                    <div class="form-text">Allowed file types: png, jpg, jpeg.</div>
                                                    <!--end::Hint-->
                                                </div>
                                                    <!--end::Input-->
                                                <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
                                            </div>
                                        </div>
                                        </div>

                                        <div class="card-footer d-flex justify-content-end py-6 px-9">
                                            <button type="reset" class="btn btn-secondary me-2">Discard</button>
                                            <button type="submit" class="btn btn-primary submitbtn">
                                                <span class="indicator-label">Save Changes</span>
                                                <span class="indicator-progress">Please wait...
                                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                            </button>
                                        </div>

                                    <input type="hidden">
                                </form>
                            </div>
                        @endcan

                        <div class="tab-pane fade" id="kt_tab_pane_3" role="tabpanel">
                            <form id="email-setting" class="form fv-plugins-bootstrap5 fv-plugins-framework" method="POST" action="{{route('save-system-setting')}}">
                                @csrf
                                <!--begin::Card body-->
                                <div class="card-body">
                                    @php
                                        $get_system_setting = get_system_setting('email_setting');
                                        $email_setting_details = json_decode($get_system_setting['value']);
                                    @endphp
                                    <div class="row mb-5">

                                            <div class="col-md-12 fv-row fv-plugins-icon-container">

                                                <label class="required fs-5 fw-semibold mb-2"> Server (Host)</label>

                                                <input type="text" class="form-control" placeholder="Please enter server (host) name" name="server_name" value="{{isset($email_setting_details->server_name) ? $email_setting_details->server_name : old('server_name') }}">

                                                @error('server_name')
                                                    <div class="alert alert-danger">{{ $message }}</div>
                                                @enderror

                                                <input type="hidden" name="key" value="email_setting">

                                            </div>


                                    </div>

                                    <div class="row mb-5">



                                        <div class="col-md-6 fv-row fv-plugins-icon-container">

                                            <label class="required fs-5 fw-semibold mb-2"> User Name</label>

                                            <input type="text" class="form-control" placeholder="Please enter user name" name="user_name" value="{{isset($email_setting_details->user_name) ? $email_setting_details->user_name : old('user_name') }}">
                                            @error('user_name')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror

                                        </div>

                                        <div class="col-md-6 fv-row fv-plugins-icon-container">

                                            <label class="required fs-5 fw-semibold mb-2">Password</label>

                                            <input type="password" class="form-control" placeholder="Please enter password" name="password" value="{{isset($email_setting_details->password) ? $email_setting_details->password : old('password') }}">
                                            @error('password')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror

                                        </div>
                                </div>

                                <div class="row mb-5">



                                    <div class="col-md-4 fv-row fv-plugins-icon-container">

                                        <label class="required fs-5 fw-semibold mb-2"> Port</label>

                                        <input type="text" class="form-control " placeholder="Please enter port" name="port" value="{{isset($email_setting_details->port) ? $email_setting_details->port : old('port') }}">
                                        @error('port')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-4 fv-row fv-plugins-icon-container">

                                        <label class="required fs-5 fw-semibold mb-2">Driver</label>

                                        <input type="text" class="form-control " placeholder="Please enter driver" name="driver" value="{{isset($email_setting_details->driver) ? $email_setting_details->driver : old('driver') }}">

                                        @error('driver')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-4 fv-row fv-plugins-icon-container">

                                        <label class="fs-5 fw-semibold mb-2">Encryption</label>

                                        <select class="form-select" name="encryption" data-control="select2" data-placeholder="Select encryption">
                                            <option></option>
                                            @if (isset($email_setting_details->encryption))
                                            <option value="SSL" {{$email_setting_details->encryption == 'SSL' ? 'selected="selected"' : ''}}>Use SSL</option>
                                            <option value="TLS" {{$email_setting_details->encryption == 'TLS' ? 'selected="selected"' : ''}}>Use TLS</option>
                                            @else
                                            <option value="SSL">Use SSL</option>
                                            <option value="TLS">Use TLS</option>
                                            @endif

                                        </select>
                                        @error('encryption')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                    </div>
                                    <!--end::Card body-->
                                    <!--begin::Actions-->
                                    <div class="card-footer d-flex justify-content-end py-6 px-9">
                                        <button type="reset" class="btn btn-secondary me-2">Discard</button>
                                        <button type="submit" class="btn btn-primary submitbtn">
                                            <span class="indicator-label">Save Changes</span>
                                            <span class="indicator-progress">Please wait...
                                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                        </button>
                                    </div>
                                    <!--end::Actions-->
                                <input type="hidden">
                            </form>
                        </div>


                        <div class="tab-pane fade" id="kt_tab_pane_4" role="tabpanel">
                            <form id="update-profile" class="form fv-plugins-bootstrap5 fv-plugins-framework" method="POST" action="">
                                @csrf
                                <div class="row g-5 g-xl-8">
                                    <div class="col-xl-6">
                                        <!--begin::List Widget 1-->
                                        <div class="card card-xl-stretch mb-xl-8">
                                            <div class="card-header border-1 cursor-pointer" >
                                                <!--begin::Card title-->
                                                <div class="card-title m-0">
                                                    <h3 class="fw-bold m-0">Twillio</h3>
                                                </div>
                                                <!--end::Card title-->
                                            </div>
                                            <form id="twillio_setting" class="form fv-plugins-bootstrap5 fv-plugins-framework" method="POST" action="">
                                                @csrf
                                                <!--begin::Card body-->
                                                <div class="card-body">

                                                    <div class="row mb-5">
                                                        <div class="col-md-12 fv-row fv-plugins-icon-container">
                                                            <label class="required fs-5 fw-semibold mb-2"> Account SID</label>
                                                            <input type="text" class="form-control" placeholder="Please enter account SID" name="account_sid">
                                                        </div>

                                                        <div class="col-md-12 fv-row fv-plugins-icon-container mt-5">
                                                            <label class="required fs-5 fw-semibold mb-2"> Auth Token</label>
                                                            <input type="text" class="form-control" placeholder="Please enter auth token" name="auth_token">
                                                        </div>
                                                    </div>

                                                    </div>
                                                    <!--end::Card body-->
                                                    <!--begin::Actions-->
                                                    <div class="card-footer d-flex justify-content-end py-6 px-9">
                                                        <button type="reset" class="btn btn-secondary me-2">Discard</button>
                                                        <button type="submit" class="btn btn-primary submitbtn">
                                                            <span class="indicator-label">Save Changes</span>
                                                            <span class="indicator-progress">Please wait...
                                                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                                        </button>
                                                    </div>
                                                    <!--end::Actions-->
                                                <input type="hidden">
                                            </form>
                                        </div>
                                        <!--end::List Widget 1-->
                                    </div>

                                </div>
                            </form>
                        </div>

                    </div>
                </div>
                <!--end::Form-->
            </div>
            <!--end::Content-->
        </div>
    </div>
    <!--end::Col-->

</div>
@endsection
