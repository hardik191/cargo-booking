@extends('backend.layout.layout')
@section('content')

@csrf
    <div class="card card-flush">
        <div class="card-header mt-2">
            <div class="card-title">
                {{-- <div class="d-flex align-items-center position-relative my-1 me-5">
                    <h3>{{ $header['title'] }}</h3>

                </div> --}}
            </div>
            @can('role add')
                <div class="card-toolbar">
                    <a href="#" class="btn btn-l fw-bold btn-primary add-role" >
                        <i class="ki-duotone ki-plus-square fs-3">
                            <span class="path1"></span>
                            <span class="path2"></span>
                            <span class="path3"></span>
                        </i> Add Role
                    </a>
                </div>
            @endcan
        </div>
        <div class="card-body pt-0 classTable">
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
        </div>
    </div>

    {{-- add --}}
    <div class="modal fade" id="add_role_modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="fw-bold">Add a Role</h2>
                    <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                        <i class="ki-duotone ki-cross fs-1">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                    </div>
                </div>
                <div class="modal-body scroll-y append-role-data-add">

                </div>
            </div>
        </div>
    </div>

    {{-- edit --}}
    <div class="modal fade" id="edit_role_modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="fw-bold">Edit a Role</h2>
                    <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                        <i class="ki-duotone ki-cross fs-1">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                    </div>
                </div>
                <div class="modal-body scroll-y append-role-data-edit">

                </div>
            </div>
        </div>
    </div>
@endsection
