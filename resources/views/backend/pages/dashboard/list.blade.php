@extends('backend.layout.layout')
@section('content')
@csrf

{{-- table --}}
<div class="row gy-5 gx-xl-10">
    <div class="col-md-6">
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
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($container_details as $con_key => $container_val )
                                <tr>
                                    <td>
                                        {{ $container_val->container_type }}
                                    </td>
                                    <td>
                                        @php
                                            if ($container_val->capacity_unit == 1) {
                                                $unit = '<span class="badge badge-outline badge-primary">KG</span>';
                                            } else {
                                                $unit = '<span class="badge badge-outline badge-primary">Tone</span>';
                                            }
                                        @endphp
                                        {{ $container_val->max_capacity }} {!! $unit !!}
                                    </td>
                                    <td>
                                        {{ $container_val->base_price }} 
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>  
    </div>
    
    <div class="col-md-6">
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
                    </table>
                </div>
            </div>
        </div>  
    </div>
</div>
@endsection