@extends('backend.layout.layout')
@section('content')
    @csrf
    <div class="card card-flush">
        {{-- @can('') --}}
        
            <div class="card-header align-items-center py-5 gap-2 gap-md-5">
                <div class="card-toolbar flex-row-fluid gap-5">
                     <div class="w-100 w-250px">
                        {{-- <label for="status_id" class="form-label">Part Name</label> --}}
                        <select name="sender_port" id="sender_port"  class="form-select sender_port" data-control="select2" data-allow-clear="true" data-placeholder="Select Seder Port">
                            <option value="all">Select Seder Port</option>
                            @foreach ($port_details as $value)
                            <option value="{{ $value->id }}" data-port_name="{{ $value->id }}">
                                {{ $value->port_name }} ({{ $value->location }})
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="w-100 w-250px">
                        {{-- <label for="status_id" class="form-label">Part No</label> --}}
                        <select name="receiver_port" id="receiver_port"  class="form-select receiver_port" data-control="select2" data-allow-clear="true" data-placeholder="Select Receiver Port">
                            <option value="all">Select Receiver Port</option>
                            @foreach ($port_details as $value)
                            <option value="{{ $value->id }}" data-port_name="{{ $value->id }}">
                                {{ $value->port_name }} ({{ $value->location }})
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                @hasrole('Customer')
                    <div class="card-toolbar">
                        <a href="{{ route('create-order') }}" class="btn btn-l fw-bold btn-primary">
                            <i class="ki-duotone ki-plus-square fs-3">
                                <span class="path1"></span>
                                <span class="path2"></span>
                                <span class="path3"></span>
                            </i> Create Order
                        </a>
                    </div>
                @endhasrole
                
            </div>
        {{-- @endcan --}}
        <div class="card-body pt-0 classTable">
            <table class="table align-middle table-row-dashed1 fs-6 gy-3 mb-0" id="shipped_order_list">
                <thead>
                    <tr class="text-start fw-bold fs-7 text-uppercase gs-0">
                        <th>#</th>
                        <th class="min-w-125px">Order Code </th>
                        <th class="min-w-125px">Sender Details</th>
                        <th class="min-w-125px">Receiver Details</th>
                        <th class="min-w-100px">Total Amount</th>
                        <th class="min-w-125px">Payment Status</th>
                        {{-- <th>Status</th> --}}
                        <th class="min-w-100px">Order Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody class="fw-semibold">

                </tbody>
            </table>
            <!--end::Table-->
        </div>
        <!--end::Card body-->
    </div>

{{-- Change Order delivery --}}
<div class="modal fade" tabindex="-1" id="orderModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Delivery Order</h3>
                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                </div>
                <!--end::Close-->
            </div>
            <div class="modal-body">
                <p class="h6">Are you sure you want to Delivery Order ?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary submitbtn yes-sure-change-order" data-kt-roles-modal-action="submit">
                    <span class="indicator-label">Yes , I am sure</span>
                    <span class="indicator-progress">Please wait...
                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                </button>
            </div>
        </div>
    </div>
</div>
@endsection
