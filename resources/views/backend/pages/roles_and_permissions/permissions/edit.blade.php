<script src="{{asset('backend/js/validate/jquery.validate.min.js')}}"></script>
<form id="edit-save-permission" method="POST" class="form" action="{{route('edit-save-permission')}}">
    @csrf
    <!--begin::Input group-->
    <div class="fv-row mb-3">
        <!--begin::Label-->
        <label class="fs-6 fw-semibold form-label mb-2">
            <span class="required">Permission Name</span>
        </label>
        <!--end::Label-->
        <!--begin::Input-->
        <input type="hidden" name="edit_id" value="{{ $permission_details->id }}">
        <input class="form-control form-control-solid" placeholder="Enter a permission name" value="{{ $permission_details->name }}" name="permission_name" />
        <!--end::Input-->
    </div>

    <div class="text-center pt-3">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary submitbtn" data-kt-permissions-modal-action="submit">
            <span class="indicator-label">Submit</span>
            <span class="indicator-progress">Please wait...
            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
        </button>
    </div>
    <!--end::Actions-->
</form>
