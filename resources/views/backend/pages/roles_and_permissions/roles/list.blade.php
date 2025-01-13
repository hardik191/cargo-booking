@extends('backend.layout.layout')
@section('content')

@csrf
    <div class="card card-flush">
        <!--begin::Card header-->
        <div class="card-header mt-2">
            <!--begin::Card title-->
            <div class="card-title">
                <!--begin::Search-->
                <div class="d-flex align-items-center position-relative my-1 me-5">
                    <h3>{{ $header['title'] }}</h3>

                </div>
                <!--end::Search-->
            </div>
            <!--end::Card title-->
            <!--begin::Card toolbar-->
            @can('role add')
                <div class="card-toolbar">
                    <!--begin::Button-->
                    <a href="#" class="btn btn-l fw-bold btn-primary add-role" >
                        <i class="fa-solid fa-plus"></i> Add Role
                    </a>
                    <!--end::Button-->
                </div>
            @endcan
            <!--end::Card toolbar-->
        </div>
        <!--end::Card header-->
        <!--begin::Card body-->
        <div class="card-body pt-0 classTable">
            <!--begin::Table-->
            <table class="table align-middle table-row-dashed fs-6 gy-3 mb-0" id="roles">
                <thead>
                    <tr class="text-start fw-bold fs-7 text-uppercase gs-0">
                        <th >#</th>
                        <th >Role Name</th>
                        <th >Actions</th>
                    </tr>
                </thead>
                <tbody class="fw-semibold">

                </tbody>
            </table>
            <!--end::Table-->
        </div>
        <!--end::Card body-->
    </div>

    {{-- add --}}
    <div class="modal fade" id="add_role_modal" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <!--begin::Modal content-->
            <div class="modal-content">
                <!--begin::Modal header-->
                <div class="modal-header">
                    <!--begin::Modal title-->
                    <h2 class="fw-bold">Add a Role</h2>
                    <!--end::Modal title-->
                    <!--begin::Close-->
                    <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                        <i class="ki-duotone ki-cross fs-1">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                    </div>
                    <!--end::Close-->
                </div>
                <!--end::Modal header-->
                <!--begin::Modal body-->
                <div class="modal-body scroll-y append-role-data-add">
                    <!--begin::Form-->

                    <!--end::Form-->
                </div>
                <!--end::Modal body-->
            </div>
            <!--end::Modal content-->
        </div>
        <!--end::Modal dialog-->
    </div>

    {{-- edit --}}
    <div class="modal fade" id="edit_role_modal" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <!--begin::Modal content-->
            <div class="modal-content">
                <!--begin::Modal header-->
                <div class="modal-header">
                    <!--begin::Modal title-->
                    <h2 class="fw-bold">Edit a Role</h2>
                    <!--end::Modal title-->
                    <!--begin::Close-->
                    <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                        <i class="ki-duotone ki-cross fs-1">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                    </div>
                    <!--end::Close-->
                </div>
                <!--end::Modal header-->
                <!--begin::Modal body-->
                <div class="modal-body scroll-y append-role-data-edit">
                    <!--begin::Form-->

                    <!--end::Form-->
                </div>
                <!--end::Modal body-->
            </div>
            <!--end::Modal content-->
        </div>
        <!--end::Modal dialog-->
    </div>
@endsection
