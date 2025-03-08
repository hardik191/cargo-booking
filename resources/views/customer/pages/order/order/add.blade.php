@extends('backend.layout.layout')
@section('content')

  <form action="{{ route('create-save-order') }}" class="form fw-bold" id="create-save-order-form" method="POST">
        @csrf
        @php
            $temp_var = 1;
        @endphp
            <input type="hidden" name="temp_var" id="temp_var" value="{{$temp_var}}">

        <div class="container-fluid">
          
            <div class="row g-5 g-xl-7 ">
                <div class="col-md-6">
                    <div class="card card-xl-stretch1 ">
                        <div class="card-header pt-1 card-header-bg">
                            <h3 class="card-title align-items-start flex-column ">
                                <span class="card-label fw-bold text-gray-900 card-colors">Sender Details</span>
                            </h3>
                        </div>
                        <div class="card-body p-9">
                            <div class="row mb-5 g-5">
                                <div class="col-md-12">
                                    <label class="required fs-6 fw-semibold form-label mb-2">Sender Name</label>
                                    <input type="text" name="sender_name" id="sender_name" class="form-control sender_name" placeholder="Please enter sender name" autocomplete="off">
                                </div>
                                <div class="col-md-12">
                                    <label class="required fs-6 fw-semibold form-label mb-2">Sender Email</label>
                                    <input type="text" name="sender_email" id="sender_email" class="form-control sender_email" placeholder="Please enter sender email" autocomplete="off">
                                </div>
                                <div class="col-md-12">
                                    <label class="required fs-6 fw-semibold form-label mb-2">Sender Phone No</label>
                                    <input type="text" name="sender_phone_no" id="sender_phone_no" class="form-control sender_phone_no onlyNumber" placeholder="Please enter sender phone no" autocomplete="off">
                                </div>
                                <div class="col-md-12">
                                    <label class=" fs-6 fw-semibold form-label mb-2">Sender Port</label>
                                    <select name="sender_port" id="sender_port"  class="form-select sender_port" data-control="select2" data-allow-clear="true" data-placeholder="Select Seder Port">
                                        <option></option>
                                        @foreach ($port_details as $value)
                                        <option value="{{ $value->id }}" data-port_name="{{ $value->id }}">
                                            {{ $value->port_name }} ({{ $value->location }})
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card card-xl-stretch1 ">
                        <div class="card-header pt-1 card-header-bg">
                            <h3 class="card-title align-items-start flex-column ">
                                <span class="card-label fw-bold text-gray-900 card-colors">Receiver Details</span>
                            </h3>
                        </div>
                        <div class="card-body p-9">
                         <div class="row mb-5 g-5">
                                <div class="col-md-12">
                                    <label class="required fs-6 fw-semibold form-label mb-2">Receiver Name</label>
                                    <input type="text" name="receiver_name" id="receiver_name" class="form-control receiver_name" placeholder="Please enter receiver name" autocomplete="off">
                                </div>
                                <div class="col-md-12">
                                    <label class="required fs-6 fw-semibold form-label mb-2">Receiver Email</label>
                                    <input type="text" name="receiver_email" id="receiver_email" class="form-control receiver_email" placeholder="Please enter receiver email" autocomplete="off">
                                </div>
                                <div class="col-md-12">
                                    <label class="required fs-6 fw-semibold form-label mb-2">Receiver Phone No</label>
                                    <input type="text" name="receiver_phone_no" id="receiver_phone_no" class="form-control receiver_phone_no onlyNumber" placeholder="Please enter receiver phone no" autocomplete="off">
                                </div>
                                <div class="col-md-12">
                                    <label class=" fs-6 fw-semibold form-label mb-2">Receiver Port</label>
                                    <select name="receiver_port" id="receiver_port"  class="form-select receiver_port" data-control="select2" data-allow-clear="true" data-placeholder="Select Receiver Port">
                                        <option></option>
                                        @foreach ($port_details as $value)
                                        <option value="{{ $value->id }}" data-port_name="{{ $value->id }}">
                                            {{ $value->port_name }} ({{ $value->location }})
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>    
                
                <div class="col-md-12">
                    <div class="card card-xl-stretch">
                        <div class="card-header pt-1 card-header-bg">
                            <h3 class="card-title align-items-start flex-column ">
                                <span class="card-label fw-bold text-gray-900 card-colors">Container Details</span>
                            </h3>
                        </div>
                        <div class="card-body p-9">
                            <div class="table-responsive classTable">
                                <table class="table table-bordered" id="container-details-table" style="border-radius: 10px !important; border: 2px solid rgb(40, 39, 39) !important;">
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
                                        @foreach ($container_details as $con_key => $container_val )
                                            <tr>
                                                <td>
                                                    <input type="hidden" name="container_id[]" value="{{ $container_val->id }}" autocomplete="off">
                                                    {{ $container_val->container_type }}
                                                </td>
                                                <td>
                                                    {{ $container_val->max_capacity }}
                                                    <input type="hidden" name="base_price[]" class="base_price" value="{{ $container_val->base_price }}">
                                                </td>
                                                <td>
                                                    {{ $container_val->base_price }}
                                                </td>
                                                <td>
                                                    <input type="text" name="my_order_qty[]" class="form-control my_order_qty onlyNumber" placeholder="{{ $container_val->container_type }} order qty" value="0" autocomplete="off">
                                                </td>
                                                <td>
                                                    <input type="text" name="my_capacity[]" class="form-control my_capacity onlyNumber" placeholder="{{ $container_val->container_type }} capacity" value="0" autocomplete="off">
                                                </td>
                                                 <td>
                                                    <input type="text" name="sub_price[]" class="form-control sub_price onlyNumber readonly" readonly placeholder="Please enter my capacity" value="0.00" autocomplete="off">
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="3" class="text-end">TOTAL QTY</td>
                                            <td class="total_qty">0</td>
                                            <td class="text-end">TOTAL PRICE</td>
                                            <td class="total_price">0</td>
                                            <input type="hidden" name="total_qty" class="total_qty" value="0" >
                                            <input type="hidden" name="total_price" class="total_price" value="0" >
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>  
                </div>
                
                <div class="col-md-12">
                    <div class="card card-xl-stretch">
                        <div class="card-header pt-1 card-header-bg">
                            <h3 class="card-title align-items-start flex-column ">
                                <span class="card-label fw-bold text-gray-900 card-colors">Charge Details</span>
                            </h3>
                        </div>
                        <div class="card-body p-9">
                            <div class="table-responsive classTable">
                                <table class="table table-bordered" id="charge-details-table" style="border-radius: 10px !important; border: 2px solid rgb(40, 39, 39) !important;">
                                    <thead>
                                        <tr class="fw-bold fs-6 text-gray-800 text-uppercase" style="border: 2px solid">
                                            <th class="min-w-150px">Charge Name</th>
                                            <th class="min-w-150px">Charge Type</th>
                                            <th class="min-w-150px">Charge Value</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($order_charge_details as $charge_key => $charge_val )

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

                                                $charge_type_badge = '<span class="badge badge-outline ' . $randomBadge . '">' . ($chargeTypes[$charge_val->charge_type] ?? 'Unknown') . '</span>';
                                            @endphp
                                            <tr>
                                                <td>
                                                    <input type="hidden" name="charge_id[]" value="{{ $charge_val->id }}" />
                                                    <input type="hidden" name="charge_type[]" class="charge_type" value="{{ $charge_val->charge_type }}">
                                                    <input type="hidden" name="charge_value[]" class="charge_value" value="{{ $charge_val->charge_value }}">
                                                    {{ $charge_val->charge_name }}
                                                </td>
                                                <td>
                                                    {!! $charge_type_badge !!}
                                                </td>
                                                <td>
                                                    {{ $charge_val->charge_value }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="2" class="text-end">TOTAL CHARGE</td>
                                            <td class="total_charge">0</td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" class="text-end">FINAL TOTAL</td>
                                            <td class="final_total">0</td>
                                            <input type="hidden" name="total_charge" class="total_charge" value="0">
                                            <input type="hidden" name="final_total" class="final_total" value="0">
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>  
                </div>
           

        </div>

        <div class="text-center pt-3 pb-3 submitButton">
            <a href="{{ url()->previous() }}" class="btn btn-secondary me-3">Back</a>
            <button type="submit" class="btn btn-primary submitbtn">
                <span class="indicator-label">Submit</span>
                <span class="indicator-progress">Please wait...
                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                </span>
            </button>
        </div>
    </form>
@endsection
