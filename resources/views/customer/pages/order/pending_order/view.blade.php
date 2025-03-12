@extends('backend.layout.layout')
@section('content')

    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-xxl">
            @php
                $paymentBadge = match ((int) $order_details->payment_status) {
                    1 => '<span class="badge badge-warning">Pending</span>',
                    2 => '<span class="badge badge-success">Successful</span>',
                    3 => '<span class="badge badge-danger">Cancelled</span>',
                    default => '<span class="badge badge-secondary">Unknown</span>',
                };

                $orderBadge = match ((int) $order_details->order_status) {
                    1 => '<span class="badge badge-outline badge-warning">Pending</span>',
                    2 => '<span class="badge badge-outline badge-primary">Accepted</span>',
                    3 => '<span class="badge badge-outline badge-danger">Rejected</span>',
                    4 => '<span class="badge badge-outline badge-info">Shipped</span>',
                    5 => '<span class="badge badge-outline badge-success">Delivery</span>',
                    default => '<span class="badge badge-outline badge-secondary">Unknown</span>',
                };
            @endphp
            <div class="row mb-7">
                <div class="col-xl-12">
                    <div class="card card-xl-stretch1">
                        <div class="card-header">
                            <div class="card-title">
                                <h2>Order Details ({{ $order_details->order_code }})</h2>
                            </div>
                            <div class="card-toolbar">
                                <span>{!! $orderBadge !!}</span>
                            </div>
                        </div>

                        <div class="card-body pt-5">
                            <div class="row mt-5">
                                <div class="col-md-6">
                                    <div class="flex-grow-1 text-muted">
                                        <div class="d-flex align-items-center">
                                            <i class="ki-duotone ki-calendar fs-2 me-2">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                            </i>Order Date
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <span class="fw-bold">{{ $order_details->created_at }}</span>
                                </div>
                            </div>
                            <div class="separator border-1 my-5"></div>
                            <div class="row mt-5">
                                <div class="col-md-6">
                                    <div class="flex-grow-1 text-muted">
                                        <div class="d-flex align-items-center">
                                            <i class="ki-duotone ki-two-credit-cart fs-2 me-2">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                                <span class="path3"></span>
                                                <span class="path4"></span>
                                                <span class="path5"></span>
                                            </i>Payment Status
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <span class="fw-bold">{!! $paymentBadge !!}</span>
                                </div>
                            </div>

                            <div class="separator border-1 my-5"></div>
                            <div class="row mt-5">
                                <div class="col-md-6">
                                    <div class="flex-grow-1 text-muted">
                                        <div class="d-flex align-items-center">
                                            <i class="ki-duotone ki-wallet fs-2 me-2">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                                <span class="path3"></span>
                                                <span class="path4"></span>
                                            </i>Payment Method
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <span
                                        class="fw-bold">{{ isset($order_details['paymentHasOne']->payment_mode) ? get_payment_mode($order_details['paymentHasOne']->payment_mode) : 'N/A' }}</span>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-5 g-xl-7">
                <div class="col-md-6">
                    <div class="card card-xl-stretch mb-xl-8">
                        <div class="card-header pt-1 card-header-bg">
                            <h3 class="card-title align-items-start flex-column ">
                                <span class="card-label fw-bold text-gray-900 card-colors">Sender Details</span>
                            </h3>
                        </div>
                        <div class="card-body p-9">
                            <div class="row mb-5 g-1">
                                <div class="col-6">
                                    <div class="flex-grow-1 text-muted">
                                        <div class="d-flex align-items-center">
                                            Sender Name
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <span class="fw-bold">{{ $order_details->sender_name }}</span>
                                </div>

                                <div class="separator border-1 my-5"></div>
                                <div class="col-6">
                                    <div class="flex-grow-1 text-muted">
                                        <div class="d-flex align-items-center">
                                            Sender Email
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <span class="fw-bold">{{ $order_details->sender_email }}</span>
                                </div>

                                <div class="separator border-1 my-5"></div>
                                <div class="col-6">
                                    <div class="flex-grow-1 text-muted">
                                        <div class="d-flex align-items-center">
                                            Sender Phone No
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <span class="fw-bold"> <span
                                            class="text-primary">+{{ $order_details->sender_country_code }}</span>
                                        {{ $order_details->sender_phone_no }}</span>
                                </div>
                                <div class="separator border-1 my-5"></div>
                                <div class="col-6">
                                    <div class="flex-grow-1 text-muted">
                                        <div class="d-flex align-items-center">
                                            Sender Port
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    @php
                                        $sender_location = $order_details->senderPortId->location
                                            ? '(' . $order_details->senderPortId->location . ')'
                                            : '';
                                        $sender_Port = $order_details->senderPortId->port_name
                                            ? $order_details->senderPortId->port_name . ' ' . $sender_location
                                            : 'N/A';
                                    @endphp
                                    <span class="fw-bold"> {{ $sender_Port }}</span>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card card-xl-stretch mb-5 mb-xl-8">
                        <div class="card-header pt-1 card-header-bg">
                            <h3 class="card-title align-items-start flex-column ">
                                <span class="card-label fw-bold text-gray-900 card-colors">Receiver Details</span>
                            </h3>
                        </div>
                        <div class="card-body p-9">

                            <div class="row mb-5 g-1">
                                <div class="col-6">
                                    <div class="flex-grow-1 text-muted">
                                        <div class="d-flex align-items-center">
                                            Receiver Name
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <span class="fw-bold">{{ $order_details->receiver_name }}</span>
                                </div>

                                <div class="separator border-1 my-5"></div>
                                <div class="col-6">
                                    <div class="flex-grow-1 text-muted">
                                        <div class="d-flex align-items-center">
                                            Receiver Email
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <span class="fw-bold">{{ $order_details->receiver_email }}</span>
                                </div>

                                <div class="separator border-1 my-5"></div>
                                <div class="col-6">
                                    <div class="flex-grow-1 text-muted">
                                        <div class="d-flex align-items-center">
                                            Receiver Phone No
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <span class="fw-bold"> <span
                                            class="text-primary">+{{ $order_details->receiver_country_code }}</span>
                                        {{ $order_details->receiver_phone_no }}</span>
                                </div>
                                <div class="separator border-1 my-5"></div>
                                <div class="col-6">
                                    <div class="flex-grow-1 text-muted">
                                        <div class="d-flex align-items-center">
                                            Receiver Port
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <span class="fw-bold">
                                        @php
                                            $receiver_location = $order_details->receiverPortId->location
                                                ? '(' . $order_details->receiverPortId->location . ')'
                                                : '';
                                            $receiver_Port = $order_details->receiverPortId->port_name
                                                ? $order_details->receiverPortId->port_name . ' ' . $receiver_location
                                                : 'N/A';
                                        @endphp
                                        {{ $receiver_Port }}
                                    </span>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-5 g-xl-7">
                <div class="col-md-12">
                    <div class="card card-xl-stretch1">
                        <div class="card-header pt-1 card-header-bg">
                            <h3 class="card-title align-items-start flex-column ">
                                <span class="card-label fw-bold text-gray-900 card-colors">Container Details</span>
                            </h3>
                        </div>
                        <div class="card-body p-9">
                            <div class="table-responsive classTable">
                                <table class="table table-bordered" id="container-details-table"
                                    style="border-radius: 10px !important; border: 2px solid rgb(40, 39, 39) !important;">
                                    <thead>
                                        <tr class="fw-bold fs-6 text-gray-800 text-uppercase" style="border: 2px solid">
                                            <th class="min-w-150px">Container Type</th>
                                            <th class="min-w-150px">Max Capacity</th>
                                            <th class="min-w-150px">Base Price ($)</th>
                                            <th class="min-w-150px">MY Order QTY</th>
                                            <th class="min-w-150px">MY Capacity</th>
                                            <th class="min-w-150px">Sub Price </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($order_details->orderContainerDetailMany as $con_key => $container_val)
                                            <tr>
                                                <td>
                                                    {{-- <input type="hidden" name="container_detail_main_id[]" value="{{ $container_val->id }}" autocomplete="off">
                                                    <input type="hidden" name="container_id[]" value="{{ $container_val->container_id }}" autocomplete="off"> --}}
                                                    {{ $container_val->containerId->container_type }}
                                                </td>
                                                <td>
                                                    @php
                                                        if ($container_val->capacity_unit == 1) {
                                                            $unit =
                                                                '<span class="badge badge-outline badge-primary">KG</span>';
                                                        } else {
                                                            $unit =
                                                                '<span class="badge badge-outline badge-primary">Tone</span>';
                                                        }
                                                    @endphp
                                                    {{ $container_val->max_capacity }} {!! $unit !!}
                                                    {{-- <input type="hidden" name="base_price[]" class="base_price" value="{{ $container_val->base_price }}"> --}}
                                                </td>
                                                <td>
                                                    {{ $container_val->base_price }}
                                                </td>
                                                <td>
                                                    {{ $container_val->my_order_qty }}
                                                    {{-- <input type="text" name="my_order_qty[]" class="form-control my_order_qty onlyNumber" placeholder="{{ $container_val->containerId->container_type }} order qty" value="{{ $container_val->my_order_qty }}" autocomplete="off"> --}}
                                                </td>
                                                <td>
                                                    {{ $container_val->my_capacity }}
                                                    {{-- <input type="text" name="my_capacity[]" class="form-control my_capacity onlyNumber" placeholder="{{ $container_val->containerId->container_type }} capacity" value="{{ $container_val->my_capacity }}" autocomplete="off"> --}}
                                                </td>
                                                <td>
                                                    {{ $container_val->sub_price }}
                                                    {{-- <input type="text" name="sub_price[]" class="form-control sub_price onlyNumber readonly" readonly placeholder="Please enter my capacity" value="{{ $container_val->sub_price }}" autocomplete="off"> --}}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="3" class="text-end">TOTAL</td>
                                            <td class="total_qty1">
                                                {{ $order_details->total_qty }}
                                                {{-- <input type="text" name="total_qty" class="form-control readonly total_qty" readonly value="{{ $order_details->total_qty }}" > --}}
                                            </td>
                                            <td class="">
                                                {{ $order_details->total_capacity }}
                                                {{-- <input type="text" name="total_capacity" class="form-control readonly total_capacity" readonly value="{{ $order_details->total_capacity }}" > --}}
                                            </td>
                                            <td class="total_price">{{ $order_details->total_price }}</td>
                                            {{-- <input type="hidden" name="total_qty" class="total_qty" value="{{ $order_details->total_qty }}" > --}}
                                            {{-- <input type="hidden" name="total_price" class="total_price" value="{{ $order_details->total_price }}" > --}}
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="card card-xl-stretch1">
                        <div class="card-header pt-1 card-header-bg">
                            <h3 class="card-title align-items-start flex-column ">
                                <span class="card-label fw-bold text-gray-900 card-colors">Charge Details</span>
                            </h3>
                        </div>
                        <form id="edit-save-order-payment-satus-form" method="POST" class="form"
                            action="{{ route('edit-save-order-payment-satus') }}">
                            @csrf
                            <div class="card-body p-9">
                                <div class="table-responsive classTable">
                                    <table class="table table-bordered" id="charge-details-table"
                                        style="border-radius: 10px !important; border: 2px solid rgb(40, 39, 39) !important;">
                                        <thead>
                                            <tr class="fw-bold fs-6 text-gray-800 text-uppercase"
                                                style="border: 2px solid">
                                                <th class="min-w-150px">Charge Name</th>
                                                <th class="min-w-150px">Charge Type</th>
                                                <th class="min-w-150px">Charge Value</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($order_details->orderChargeDetailMany as $charge_key => $charge_detail_val)
                                                @php
                                                    $charge_type_badge = '';
                                                    $badgeClasses = [
                                                        'badge-primary',
                                                        // 'badge-secondary',
                                                        // 'badge-success',
                                                        // 'badge-info',
                                                        // 'badge-warning',
                                                        // 'badge-danger',
                                                        // 'badge-dark'
                                                    ];

                                                    $randomBadge = $badgeClasses[array_rand($badgeClasses)]; // Pick a random badge

                                                    $charge_type_badge =
                                                        '<span class="badge badge-outline ' .
                                                        $randomBadge .
                                                        '">' .
                                                        ($chargeTypes[$charge_detail_val->charge_type] ?? 'Unknown') .
                                                        '</span>';
                                                @endphp
                                                <tr>
                                                    <td>
                                                        {{-- <input type="hidden" name="charge_detail_main_id[]" value="{{ $charge_detail_val->id }}" />
                                                        <input type="hidden" name="charge_id[]" value="{{ $charge_detail_val->charge_id }}" />
                                                        <input type="hidden" name="charge_type[]" class="charge_type" value="{{ $charge_detail_val->charge_type }}">
                                                        <input type="hidden" name="charge_value[]" class="charge_value" value="{{ $charge_detail_val->charge_value }}"> --}}
                                                        {{ $charge_detail_val->chargeId->charge_name }}
                                                    </td>
                                                    <td>
                                                        {!! $charge_type_badge !!}
                                                    </td>
                                                    <td>
                                                        {{ $charge_detail_val->charge_value }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="2" class="text-end">TOTAL CHARGE</td>
                                                <td class="total_charge">{{ $order_details->total_charge }}</td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" class="text-end">FINAL TOTAL</td>
                                                <td class="final_total">{{ $order_details->final_total }}</td>
                                                {{-- <input type="hidden" name="total_charge" class="total_charge" value="{{ $order_details->total_charge }}">
                                                <input type="hidden" name="final_total" class="final_total" value="{{ $order_details->final_total }}"> --}}
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>

                                @if ($order_details->payment_status == 1)
                                    <div class="row g-5 g-xl-7">
                                        <input type="hidden" name="editId" value="{{ $order_details->id }}">
                                        <div class="col-md-6">
                                            <label class="required fs-6 fw-semibold form-label mb-2">Payment Status</label>
                                            <select class="form-select  select-change-payment-status"
                                                name="payment_status" id="payment_status" data-control="select2"
                                                data-allow-clear="true" data-placeholder="Select Payment Status"
                                                data-hide-search="true">
                                                <option></option>
                                                {{-- <option value="1"  {{ $order_details->payment_status == 1 ? "selected" : ''}}>Pending</option> --}}
                                                <option value="2"
                                                    {{ $order_details->payment_status == 2 ? 'selected' : '' }}>Received
                                                </option>
                                                {{-- <option value="3"  {{ $order_details->payment_status == 3 ? "selected" : ''}}>Not Received</option> --}}
                                            </select>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="required fs-6 fw-semibold form-label mb-2">Payment Mode</label>
                                            <select class="form-select form-select-solid1 select3 select-payment-mode"
                                                name="payment_mode" id="payment_mode" data-control="select2"
                                                data-allow-clear="true" data-placeholder="Select Payment Mode"
                                                data-hide-search="true">
                                                <option value="">Select Payment Mode</option>
                                                @foreach ($paymentMode as $key => $value)
                                                    <option value="{{ $key }}">{{ $value }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                       <div class="alert alert-warning d-flex align-items-center p-5">
                                            <i class="ki-duotone ki-shield-tick fs-2hx text-warning-2 me-4">
                                                <span class="path1"></span><span class="path2"></span>
                                            </i> 
                                            <div class="d-flex flex-column">
                                                <h4 class="mb-1 text-warning-2 text-gray-200">Warning</h4>
                                                <span class="fs-5 text-dark">This order is confirmed after payment. The order will be delivered soon after payment is sent.</span>
                                            </div>
                                        </div>
                                        
                                    </div>
                                @endif
                            </div>
                            @if ($order_details->payment_status == 1 && $order_details->is_accepted_order == 2)
                                <div class="card-footer text-center">
                                    <a href="{{ url()->previous() }}" class="btn btn-secondary me-3">Back</a>
                                    <button type="submit" class="btn btn-primary submitbtn">
                                        <span class="indicator-label">Submit</span>
                                        <span class="indicator-progress">Please wait...
                                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                        </span>
                                    </button>
                                </div>
                            @endif
                        </form>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="card card-xl-stretch1">
                        <div class="card-header">
                            <div class="card-title">
                                <h2>Order History</h2>
                            </div>
                        </div>

                        <div class="card-body pt-0">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle table-row-dashed fs-6 gy-5 mb-0">
                                    <thead>
                                        <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                                            {{-- <th class="min-w-100px">Order Code</th> --}}
                                            <th class="min-w-100px">Action Date</th>
                                            <th class="min-w-175px">Description</th>
                                            <th class="min-w-70px">Order Status</th>
                                        </tr>
                                    </thead>
                                    <tbody class="fw-semibold text-gray-600">
                                        @if ($order_details->orderHistoryMany->isNotEmpty())
                                            @foreach ($order_details->orderHistoryMany as $history_val)
                                                @php
                                                    $payment_status = '';

                                                    $status = get_order_status($history_val->order_status);

                                                    $status = get_order_status($history_val->order_status);

                                                    if ($history_val['order_status'] == 6) {
                                                        $payment_status .=
                                                            '
                                                                <i class="ki-duotone ki-timer fs-3 " style="color: ' .
                                                            $status['color'] .
                                                            ';">
                                                                    <span class="path1"></span>
                                                                    <span class="path2"></span>
                                                                    <span class="path3"></span>
                                                                </i>';
                                                    } elseif ($history_val['order_status'] == 7) {
                                                        $payment_status .= '
                                                                <i class="ki-duotone ki-check-circle fs-4 text-success">
                                                                    <span class="path1"></span>
                                                                    <span class="path2" ></span>
                                                                </i>';
                                                    } elseif ($history_val['order_status'] == 8) {
                                                        $color = $status['color'];
                                                        $payment_status .= "
                                                            <i class='ki-duotone ki-cross-circle fs-4' style='color: {$color};'>
                                                                <span class='path1'></span>
                                                                <span class='path2'></span>
                                                            </i>";
                                                    } else {
                                                        $payment_status .= '';
                                                    }
                                                @endphp
                                                <tr>
                                                    {{-- <td>#{{ $history_val->orderId->order_code }}</td> --}}
                                                    <td>{{ enterDateforment($history_val->created_at, 'd-m-Y H:i A') }}
                                                    </td>
                                                    <td>{{ $history_val->description }}</td>
                                                    <td>
                                                        <span class="py-3 px-4 fw-bold rounded text-nowrap"
                                                            style="color: {{ $status['color'] }}; background-color: {{ $status['background-color'] }};">
                                                            {!! $payment_status !!}
                                                            {{ $status['title'] }}
                                                        </span>
                                                    </td>
                                                    {{-- <td>{{ get_order_status($history_val->order_status) }}</td> --}}
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="4" class="text-center text-gray-500">
                                                    No Data Available
                                                </td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>


@endsection
