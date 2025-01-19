@extends('backend.layout.layout')
@section('content')

@csrf
    <div class="card card-flush">
        {{-- <div class="card-header mt-2">
            <div class="card-title">
                <div class="d-flex align-items-center position-relative my-1 me-5">
                    <h3>{{ $header['title'] }}</h3>
                </div>
            </div>
            <div class="card-toolbar">
                @can('permission add')
                <a href="#" class="btn btn-l fw-bold btn-primary add-permission" >
                    <i class="ki-duotone ki-plus-square fs-3">
                        <span class="path1"></span>
                        <span class="path2"></span>
                        <span class="path3"></span>
                    </i> Add Permission</a>
                @endcan
            </div>
        </div> --}}

        <div class="card-body pt-0 classTable">
            <table class="table table-bordered " id="customer_list">
                <thead>
                    <tr class="text-start fw-bold fs-7 text-uppercase gs-0">
                        <th >#</th>
                        <th >Name</th>
                        <th >Email</th>
                        <th >Phone NO</th>
                        <th class="mw-sm-95px">Ragister Date</th>
                        <th class="mw-sm-80px">Status</th>
                        <th class="mw-sm-60px">Actions</th>
                    </tr>
                </thead>
                <tbody class="fw-semibold">

                </tbody>
            </table>
        </div>
    </div>

@endsection
