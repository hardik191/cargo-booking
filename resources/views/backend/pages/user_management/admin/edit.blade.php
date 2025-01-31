@extends('backend.layout.layout')
@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.13/css/intlTelInput.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.13/js/intlTelInput.min.js"></script>

<style>
    .iti {
        width: 100%;
    }
</style>

<div class="row gy-5 gx-xl-10">
    <div class="col-xl-12 mb-xl-10">
        <div class="card mb-5 mb-xl-10">
            <div id="kt_account_add_backend_user" class="collapse show">
                <form id="edit_admin_user_form" class="form fv-plugins-bootstrap5 fv-plugins-framework" method="POST" action="{{route('edit-save-admin')}}">
                    @csrf
                    <input type="hidden" name="edit_id" value="{{ $user_list->id }}">
                    <div class="card-body p-9">


                        <div class="row g-5 g-xl-8 mb-5">
                            <div class="col-md-6">
                                <label class="form-label required">Full Name</label>
                                <input type="text" class="form-control form-control-solid form-control-lg" autocomplete="off" name="name" id="name" placeholder="Please enter full name" value="{{ $user_list->name }}"/>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label required">Email</label>
                                <input type="text" class="form-control form-control-solid form-control-lg " autocomplete="off" name="email" id="email" placeholder="Please enter email" value="{{ $user_list->email }}" autocomplete="off" />
                            </div>

                            <div class="col-md-6">
                                <label class="fs-6 fw-semibold form-label required">Phone No </label>
                                <input name="phone_no" id="phone_no" class="form-control form-control-solid form-control-lg onlyNumber"
                                    autocomplete="off" type="text" value="{{ $user_list->phone_no }}"/>
                                <input type="hidden" name="country_code" id="country_code" value="{{ $user_list->country_code }}">

                            </div>

                            <div class="col-md-6">
                                <label class="form-label required">Role</label>
                                <select name="role" id="role" class="form-select form-select-solid form-select-lg " data-control="select2" data-placeholder="Select Role" data-allow-clear="true">
                                    @foreach($roles as $value)
                                        <option value="{{ $value->name }}" @if($user_list->getRoleNames()->first() == $value->name) selected @endif>
                                            {{ ucfirst($value->name) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>


                            <div class="col-md-6">
                                <div class="mb-1">
                                    <label class="form-label required">Password</label>
                                    <div class="input-group position-relative">
                                        <input class="form-control input-group-required form-control-lg" type="password" placeholder="Password" name="password" id="password" autocomplete="off" data-kt-translate="sign-up-input-password" />
                                        <span class="input-group-text" data-kt-password-meter-control="visibility">
                                            <i class="ki-duotone ki-eye-slash fs-1"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span></i>
                                            <i class="ki-duotone ki-eye d-none fs-1"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
                                        </span>

                                    </div>
                                    <div class="d-flex align-items-center mb-3 mt-5" data-kt-password-meter-control="highlight">
                                        <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2 "></div>
                                        <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                                        <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                                        <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px"></div>
                                    </div>
                                    <div class="text-muted">Use 8 or more characters with a mix of letters, numbers &amp; symbols.<div></div></div>
                                    <div class="help-block password-error"></div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="fv-row corporate-field " data-kt-password-meter="true">
                                    <label class="form-label ">Confirm Password</label>
                                    <div class="input-group position-relative">
                                        <input class="form-control input-group-required form-control-lg" type="password" placeholder="Confirm password" name="confirm_password" id="confirm_password" autocomplete="off" data-kt-translate="sign-up-input-password"/>
                                        <span class="input-group-text" data-kt-password-meter-control="visibility">
                                            <i class="ki-duotone ki-eye-slash fs-1"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span></i>
                                            <i class="ki-duotone ki-eye d-none fs-1"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
                                        </span>

                                    </div>

                                    <div class="help-block confirm-password-error"></div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-center py-6 px-9">
                        <a href="{{ route('admin-list') }}" class="btn btn-secondary me-3">Back</a>
                        <button type="submit" class="btn btn-primary submitbtn">
                            <span class="indicator-label">Submit</span>
                            <span class="indicator-progress">Please wait...
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
@endsection
