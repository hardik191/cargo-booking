@extends('backend.layout.layout')
@section('content')
@php
$get_system_setting = get_system_setting('branding');
$branding_details = json_decode($get_system_setting['value']);
$auth_user = Auth::user();
@endphp

<style>
    .card-xl-stretch-style{
        border: 1px;
        color: {{$branding_details->sidebar_active_font_color}};
        background-color: {{$branding_details->sidebar_active_color}};
    }

    .card .card-header .card-title {
    display: flex;
    align-items: center;
    margin: -1.5rem;
    margin-left: 0;
    }
    @media (min-width: 1200px) {
    .h-xl-100 {
        height: 95% !important;
    }
    }

    .text-white{
        color:{{$branding_details->sidebar_active_font_color}} !important;

    }

    .sub-title-size{
        font-size:16px !important;
    }
    .card-title-main {
        color:{{$branding_details->sidebar_menu_font_color}} !important;
    }

    .card-title-size{
        font-size:18px;

    }


    .card.hoverable:hover {
    background-color: {{$branding_details->hover_color}} !important; /* Change to your preferred hover color */
    color: {{$branding_details->hover_font_color}} !important; /* Change text color if needed */
    }

    .card.hoverable:hover .text-white {
        color: {{$branding_details->hover_font_color}} !important; /* Ensure text color changes on hover */
    }

    /* //test */


</style>

@canany(['role list', 'customer list', 'admin list'])
    <div class="row g-5 g-xl-10">
        <div class="col-xl-12 mb-4">
            <div class="card card-flush h-xl-100">
                <div class="card-header  align-items-start h-200px" style="background-color:{{$branding_details->sidebar_color}}" data-bs-theme="light">
                    <h3 class="card-title align-items-start flex-column card-title-main pt-15">
                        <span class="fw-bold card-title-size mb-3">User Management</span>
                    </h3>

                </div>
                <div class="card-body mt-n20">
                    <div class="mt-n20 position-relative">
                        <div class="row g-3 g-lg-6">
                            @can('role list')
                                <div class="col-xl-4">
                                    <a href="{{route('roles')}}" class="card hoverable card-xl-stretch-style">
                                        <div class="card-body">
                                            <span class="text-white fs-2x ms-n1"> 0</span>

                                            <div class="text-white fw-bold fs-2 mb-2 mt-5 sub-title-size">Roles </div>

                                        </div>
                                    </a>
                                </div>
                            @endcan

                            @can('customer list')
                                <div class="col-xl-4">
                                    <a href="{{route('customer-list')}}" class="card hoverable card-xl-stretch-style">
                                        <div class="card-body">
                                            <span class="text-white fs-2x ms-n1"> 0</span>

                                            <div class="text-white fw-bold fs-2 mb-2 mt-5 sub-title-size">Customer</div>
                                            {{-- <div class="fw-semibold text-white">Flats, Shared Rooms, Duplex</div> --}}
                                        </div>
                                    </a>
                                </div>
                            @endcan

                            @can('admin list')
                                <div class="col-xl-4">
                                    <a href="{{route('admin-list')}}" class="card hoverable card-xl-stretch-style mb-5">
                                        <div class="card-body">
                                            <span class="text-white fs-2x ms-n1">0</span>

                                            <div class="text-white fw-bold fs-2 mb-2 mt-5 sub-title-size">Admin</div>
                                            {{-- <div class="fw-semibold text-white">50% Increased for FY20</div> --}}
                                        </div>
                                    </a>
                                </div>
                            @endcan
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endcanany

@canany(['port list', 'order-charge list', 'container list'])
    <div class="row g-5 g-xl-10">
        <div class="col-xl-12 mb-4">
            <div class="card card-flush h-xl-100">
                <div class="card-header  align-items-start h-200px" style="background-color:{{$branding_details->sidebar_color}}" data-bs-theme="light">
                    <h3 class="card-title align-items-start flex-column card-title-main pt-15">
                        <span class="fw-bold card-title-size mb-3">Master Management</span>
                    </h3>

                </div>
                <div class="card-body mt-n20">
                    <div class="mt-n20 position-relative">
                        <div class="row g-3 g-lg-6">
                            @can('port list')
                                <div class="col-xl-4">
                                    <a href="{{route('port-list')}}" class="card hoverable card-xl-stretch-style">
                                        <div class="card-body">
                                            <span class="text-white fs-2x ms-n1"> 0</span>

                                            <div class="text-white fw-bold fs-2 mb-2 mt-5 sub-title-size">Port </div>

                                        </div>
                                    </a>
                                </div>
                            @endcan

                            @can('container list')
                                <div class="col-xl-4">
                                    <a href="{{route('container-list')}}" class="card hoverable card-xl-stretch-style">
                                        <div class="card-body">
                                            <span class="text-white fs-2x ms-n1"> 0</span>

                                            <div class="text-white fw-bold fs-2 mb-2 mt-5 sub-title-size">Container</div>
                                            {{-- <div class="fw-semibold text-white">Flats, Shared Rooms, Duplex</div> --}}
                                        </div>
                                    </a>
                                </div>
                            @endcan

                            @can('order-charge list')
                                <div class="col-xl-4">
                                    <a href="{{route('order-charge-list')}}" class="card hoverable card-xl-stretch-style mb-5">
                                        <div class="card-body">
                                            <span class="text-white fs-2x ms-n1">0</span>

                                            <div class="text-white fw-bold fs-2 mb-2 mt-5 sub-title-size">Order Charge</div>
                                            {{-- <div class="fw-semibold text-white">50% Increased for FY20</div> --}}
                                        </div>
                                    </a>
                                </div>
                            @endcan
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endcanany
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