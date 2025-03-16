@extends('backend.layout.layout')
@section('content')

@php


$data = Auth()->user();


if($data['user_image'] != '' || $data['user_image'] != null ){
    $image = asset('storage/uploads/userprofile/' . $data['user_image']);
}else{
    $image = url("backend/upload/userprofile/default.jpg");
}

@endphp

<div class="row gy-5 gx-xl-10">
    <div class="col-xl-12 mb-xl-10">
        <div class="card mb-5 mb-xl-10">
            <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse" data-bs-target="#kt_account_profile_details" aria-expanded="true" aria-controls="kt_account_profile_details">
                <div class="card-title m-0">
                    <h3 class="fw-bold m-0">{{$header['title']}}</h3>
                </div>
            </div>
            <div id="kt_account_settings_profile_details" class="collapse show">
                <form id="update-profile" class="form fv-plugins-bootstrap5 fv-plugins-framework" method="POST" action="{{route('update-save-profile')}}">
                    @csrf
                    <div class="card-body border-top p-9">
                        <div class="row mb-6">
                            <div class="col-md-3 fv-row fv-plugins-icon-container">
                            </div>
                            <div class="col-md-6 fv-row fv-plugins-icon-container text-center">
                                <label class=" col-form-label fw-semibold fs-6">Profile Image</label>
                            <div class="">
                                <div class="image-input image-input-outline" data-kt-image-input="true" style="background-image: url('assets/media/svg/avatars/blank.svg')">
                                    <div class="image-input-wrapper w-125px h-125px" style="background-image: url({{$image}})"></div>
                                    <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" aria-label="Change avatar" data-bs-original-title="Change avatar" data-kt-initialized="1">
                                        <i class="ki-duotone ki-pencil fs-7">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                        <input type="file" name="user_image" accept=".png, .jpg, .jpeg">
                                        <input type="hidden" name="avatar_remove">
                                    </label>
                                    <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="cancel" data-bs-toggle="tooltip" aria-label="Cancel avatar" data-bs-original-title="Cancel avatar" data-kt-initialized="1">
                                        <i class="ki-duotone ki-cross fs-2">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                    </span>
                                    <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="remove" data-bs-toggle="tooltip" aria-label="Remove avatar" data-bs-original-title="Remove avatar" data-kt-initialized="1">
                                        <i class="ki-duotone ki-cross fs-2">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                    </span>
                                </div>
                                <div class="form-text">Allowed file types: png, jpg, jpeg.</div>
                            </div>
                            <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div></div>

                            <div class="col-md-3 fv-row fv-plugins-icon-container">

                            </div>

                        </div>
                        <div class="row mb-5">
                            <div class="col-md-6 fv-row fv-plugins-icon-container">
                                <label class="required fs-5 fw-semibold mb-2"> Name</label>
                                <input type="text" class="form-control form-control-solid" placeholder="Please enter name" name="name" value="{{$data['name']}}">
                            <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div></div>
                            <div class="col-md-6 fv-row fv-plugins-icon-container">
                                <label class="required fs-5 fw-semibold mb-2">Email</label>
                                <input type="text" class="form-control form-control-solid" placeholder="Please enter email" value="{{$data['email']}}" name="email">
                                <input type="hidden" name="editId" value="{{$data['id']}}">
                            <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div></div>

                             {{-- <div class="col-md-4 fv-row fv-plugins-icon-container">
                                <label class="required fs-5 fw-semibold mb-2">Mobile No</label>
                                <input type="text" class="form-control form-control-solid" placeholder="Please enter mobile number" name="mobile_no">
                            <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div></div> --}}
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-end py-6 px-9">
                        <a href="{{ url()->previous() }}" class="btn btn-secondary me-2">Back</a>
                        <button type="submit" class="btn btn-primary submitbtn">
                            <span class="indicator-label">Save Changes</span>
                            <span class="indicator-progress">Please wait...
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                        </button>
                    </div>
                <input type="hidden"></form>
            </div>
        </div>
    </div>

</div>
@endsection
