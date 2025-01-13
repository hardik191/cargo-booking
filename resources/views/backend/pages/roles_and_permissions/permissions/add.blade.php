<script src="{{ asset('backend/js/validate/jquery.validate.min.js') }}"></script>
<form id="add-save-permission" method="POST" class="form" action="{{ route('add-save-permission') }}">
    @csrf
    <!--begin::Input group-->
    <div class="fv-row mb-3">
        <!--begin::Label-->
        <label class="fs-6 fw-semibold form-label mb-2">
            <span class="required">Permission Name</span>
        </label>
        <!--end::Label-->
        <!--begin::Input-->
        <input class="form-control form-control-solid" placeholder="Enter a permission name" name="permission_name" />
        <!--end::Input-->
    </div>

    <div class="text-center pt-3">
        <button type="reset" class="btn btn-light me-3" data-kt-permissions-modal-action="cancel">Discard</button>
        <button type="submit" class="btn btn-primary submitbtn" data-kt-permissions-modal-action="submit">
            <span class="indicator-label">Submit</span>
            <span class="indicator-progress">Please wait...
                <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
        </button>
    </div>
    <!--end::Actions-->
</form>
