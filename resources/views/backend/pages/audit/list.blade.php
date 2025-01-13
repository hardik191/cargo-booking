@extends('backend.layout.layout')
@section('content')

@csrf
    <div class="card card-flush">
        <!--begin::Card header-->
        <div class="card-header mt-2">
            <!--begin::Card title-->
            <div class="card-title">
                <!--begin::Search-->
                <div class="d-flex align-items-center position-relative my-1 me-5">
                    <h3>
                        {{$header['title']}}
                    </h3>
                </div>
                <!--end::Search-->
            </div>
            <!--end::Card title-->
        </div>
        <!--end::Card header-->
        <!--begin::Card body-->
        <div class="card-body pt-0">
            <!--begin::Table-->
            <table class="table align-middle table-row-dashed fs-6 gy-3 mb-0" id="audits">
                <thead>
                    <tr class="text-start fw-bold fs-7 text-uppercase gs-0">
                        <th>#</th>
                        <th>User</th>
                        <th>Model</th>
                        <th>Action</th>
                        <th>Time</th>
                        <th>Old Values</th>
                        <th>New Values</th>
                        <th>Url</th>
                        <th>Ip Adrress</th>
                        <th>Navegador</th>
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
