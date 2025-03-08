@extends('backend.layout.layout')
@section('content')
    @csrf
    <div class="card card-flush">
        {{-- @can('') --}}
            <div class="card-header mt-2">
                <div class="card-title">
                </div>
                <div class="card-toolbar">
                    <a href="{{ route('create-order') }}" class="btn btn-l fw-bold btn-primary">
                        <i class="ki-duotone ki-plus-square fs-3">
                            <span class="path1"></span>
                            <span class="path2"></span>
                            <span class="path3"></span>
                        </i> Create Order
                    </a>
                </div>
            </div>
        {{-- @endcan --}}
        <div class="card-body pt-0 classTable">
            <table class="table align-middle table-row-dashed fs-6 gy-3 mb-0" id="pending_order_list">
                <thead>
                    <tr class="text-start fw-bold fs-7 text-uppercase gs-0">
                        <th>#</th>
                        <th class="min-w-125px">Order Code </th>
                        <th class="min-w-100px">Sender Details</th>
                        <th class="min-w-100px">Receiver Details</th>
                        <th class="min-w-100px">Total Amount</th>
                        <th class="min-w-100px">Payment Status</th>
                        <th>Status</th>
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
@endsection
