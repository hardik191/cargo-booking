<script src="{{asset('backend/js/validate/jquery.validate.min.js')}}"></script>
<form id="add-save-role" method="POST" class="form" action="{{route('add-save-role')}}">
    @csrf
    <!--begin::Input group-->
    <div class="fv-row mb-3">
        <!--begin::Label-->
        <label class="fs-6 fw-semibold form-label mb-2">
            <span class="required">Role Name</span>
        </label>
        <!--end::Label-->
        <!--begin::Input-->
        <input class="form-control form-control-solid" placeholder="Enter a role name" name="role_name" />

        <div class="fv-row mb-3">
            <label class="fs-5 fw-bold form-label mb-2 mt-3">Role Permissions</label>
            <div class="table-responsive">
                <table class="table align-middle table-row-dashed fs-6 gy-5">
                    <tbody class="text-gray-600 fw-semibold">
                        {{-- <tr>
                            <td class="text-gray-800">Administrator Access
                            <span class="ms-1" data-bs-toggle="tooltip" aria-label="Allows a full access to the system" data-bs-original-title="Allows a full access to the system" data-kt-initialized="1">
                                <i class="ki-duotone ki-information-5 text-gray-500 fs-6">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                    <span class="path3"></span>
                                </i>
                            </span></td>
                            <td>
                                <!--begin::Checkbox-->
                                <label class="form-check form-check-sm form-check-custom form-check-solid me-9">
                                    <input class="form-check-input" type="checkbox" value="" id="kt_roles_select_all">
                                    <span class="form-check-label" for="kt_roles_select_all">Select all</span>
                                </label>
                                <!--end::Checkbox-->
                            </td>
                        </tr> --}}

                        @foreach ($permissions_list as $firstWord => $permission_val)
                        <tr>
                            <td class="text-gray-800">
                                <label class="form-check form-check-sm form-check-custom form-check-solid ">
                                    <span class="me-2">{{ ucwords(str_replace('-', ' ', $firstWord)) }} </span>
                                    <input class="form-check-input permission-all me-2" data-id="{{$firstWord}}" type="checkbox">
                                </label>
                            </td>
                            @foreach ($permission_val as $permission)
                            <td>
                                <div class="d-flax">
                                    <!--begin::Checkbox-->
                                    <label class="form-check form-check-sm form-check-custom form-check-solid me-2 ">
                                        <input class="form-check-input permission-{{$firstWord}}" type="checkbox" value="{{$permission->name}}" name="permission[]">
                                        <span class="form-check-label">{{ ucfirst(Str::of($permission->name)->after(' ')) }}</span>
                                    </label>
                                </div>
                            </td>
                            @endforeach
                        </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>

    <div class="text-center pt-3">
        <button type="reset" class="btn btn-secondary me-3" data-kt-roles-modal-action="cancel">Discard</button>
        <button type="submit" class="btn btn-primary submitbtn" data-kt-roles-modal-action="submit">
            <span class="indicator-label">Submit</span>
            <span class="indicator-progress">Please wait...
            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
        </button>
    </div>
    <!--end::Actions-->
</form>
