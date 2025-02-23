@extends('backend.layout.layout')
@section('content')

@csrf
    <div class="card card-flush">
        @can('port add')
            <div class="card-header align-items-center py-5 gap-2 gap-md-5">
                <div class="card-toolbar flex-row-fluid gap-5">

                </div>
                <div class="card-toolbar">

                    <a href="javascript:;" class="btn btn-l fw-bold btn-primary add-port" >
                        <i class="ki-duotone ki-plus-square fs-3">
                            <span class="path1"></span>
                            <span class="path2"></span>
                            <span class="path3"></span>
                        </i> Add Port</a>

                </div>
            </div>
        @endcan

        <div class="card-body pt-0 classTable">
            <table class="table table-bordered " id="port_list">
                <thead>
                    <tr class="text-start fw-bold fs-7 text-uppercase gs-0">
                        <th >#</th>
                        <th class="min-w-100px">Port</th>
                        <th class="mw-sm-80px">Status</th>
                        <th class="mw-sm-60px">Actions</th>
                    </tr>
                </thead>
                <tbody class="fw-semibold">

                </tbody>
            </table>
        </div>
    </div>

{{-- add port --}}
    <div class="modal fade" id="add_port_modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="fw-bold">Add Port</h2>
                    <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                        <i class="ki-duotone ki-cross fs-1">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                    </div>
                </div>
                <form id="add-save-port-form" method="POST" class="form" action="{{route('add-save-port')}}">
                @csrf

                    <div class="modal-body scroll-y append-port-data-add">

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

    <div class="modal fade" id="edit_port_modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered ">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="fw-bold">Edit Notice</h2>
                    <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                        <i class="ki-duotone ki-cross fs-1">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                    </div>
                </div>
                <div class="modal-body scroll-y append-port-data-edit">

                </div>
            </div>
        </div>
    </div>
@endsection
