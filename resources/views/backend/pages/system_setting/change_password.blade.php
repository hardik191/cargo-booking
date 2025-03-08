@extends('backend.layout.layout')
@section('content')

    <div class="card ">
        
        <form action="{{ route('change-save-password') }}" method="post" id="change-password-form" > 
            <div class="card-body">

                @csrf
                <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                <div class="row g-5 g-xl-8">
                    <div class="col-md-12" data-kt-password-meter="true">
                        <label class="required fs-6 fw-semibold form-label mb-2">Old Password</label>
                        <div class="input-group position-relative">
                            <input class="form-control form-control-lg input-group-required" type="password" placeholder="Old password" name="old_password" id="old_password" autocomplete="off" data-kt-translate="sign-up-input-password"/>                                            <span class="input-group-text" data-kt-password-meter-control="visibility">
                                <i class="ki-duotone ki-eye-slash fs-1"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span></i>
                                <i class="ki-duotone ki-eye d-none fs-1"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
                            </span>

                        </div>
                        <div class="help-block old-password-error"></div>
                    </div>
                    
                    <div class="col-md-12" data-kt-password-meter="true">
                        <label class="required fs-6 fw-semibold form-label mb-2">New Password</label>
                        <div class="input-group position-relative ">
                            <input class="form-control form-control-lg input-group-required" type="password" placeholder="New Password" name="new_password" id="new_password" autocomplete="off" data-kt-translate="sign-up-input-password" />
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
                        <div class="help-block new-password-error "></div>
                    </div>

                    <div class="col-md-12" data-kt-password-meter="true">
                        <label class="required fs-6 fw-semibold form-label mb-2">Confirm Password</label>
                        <div class="input-group position-relative">
                            <input class="form-control form-control-lg input-group-required" type="password" placeholder="Confirm password" name="confirm_password" id="confirm_password" autocomplete="off" data-kt-translate="sign-up-input-password"/>                                            <span class="input-group-text" data-kt-password-meter-control="visibility">
                                <i class="ki-duotone ki-eye-slash fs-1"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span></i>
                                <i class="ki-duotone ki-eye d-none fs-1"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
                            </span>

                        </div>
                        <div class="help-block confirm-password-error"></div>
                    </div>

                </div>
            </div>
        
        <div class="card-footer text-center">
            <a href="{{ url()->previous() }}" class="btn btn-secondary me-3">Back</a>
            <button type="submit" class="btn btn-primary submitbtn">
                <span class="indicator-label">Submit</span>
                <span class="indicator-progress">Please wait...
                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                </span>
            </button>
        </div>
        </form>

    </div>
@endsection
