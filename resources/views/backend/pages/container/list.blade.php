@extends('backend.layout.layout')
@section('content')

@csrf
    <div class="card card-flush">
        @can('container add')
            <div class="card-header align-items-center py-5 gap-2 gap-md-5">
                <div class="card-toolbar flex-row-fluid gap-5">

                </div>
                <div class="card-toolbar">

                    <a href="javascript:;" class="btn btn-l fw-bold btn-primary add-container" >
                        <i class="ki-duotone ki-plus-square fs-3">
                            <span class="path1"></span>
                            <span class="path2"></span>
                            <span class="path3"></span>
                        </i> Add Container</a>

                </div>
            </div>
        @endcan

        <div class="card-body pt-0 classTable">
            <table class="table align-middle fs-6 gy-3 mb-0" id="container_list">
                <thead>
                    <tr class="text-start fw-bold fs-7 text-uppercase gs-0">
                        <th >#</th>
                        <th class="min-w-100px">Container Type</th>
                        {{-- <th class="min-w-100px">Max Container</th> --}}
                        <th class="min-w-100px">Max Capacity</th>
                        <th>Base Price</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody class="fw-semibold">

                </tbody>
            </table>
        </div>
    </div>

{{-- add Container --}}
    <div class="modal fade" id="add_container_modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered mw-700px">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="fw-bold">Add Container</h2>
                    <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                        <i class="ki-duotone ki-cross fs-1">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                    </div>
                </div>
                <form id="add-save-container-form" method="POST" class="form" action="{{route('add-save-container')}}">
                @csrf

                    <div class="modal-body scroll-y append-container-data-add">

                    </div>
                    <div class="modal-footer">
                        <button type="reset" class="btn btn-light me-3" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary submitbtn" >
                            <span class="indicator-label">Submit</span>
                            <span class="indicator-progress">Please wait...
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    {{-- edit Container --}}
    <div class="modal fade" id="edit_container_modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered mw-700px">
            <div class="modal-content ">
                <div class="modal-header">
                    <h2 class="fw-bold">Edit Container</h2>
                    <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                        <i class="ki-duotone ki-cross fs-1">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                    </div>
                </div>
                <form id="edit-save-container-form" method="POST" class="form" action="{{route('edit-save-container')}}">
                @csrf

                    <div class="modal-body scroll-y append-container-data-edit">

                    </div>
                    <div class="modal-footer">
                        <button type="reset" class="btn btn-light me-3" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary submitbtn" >
                            <span class="indicator-label">Submit</span>
                            <span class="indicator-progress">Please wait...
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
