@extends('backend.layout.layout')
@section('content')

@csrf
    <div class="card card-flush">
        <div class="card-header align-items-center py-5 gap-2 gap-md-5">
            <!--begin::Card title-->
            <div class="card-toolbar flex-row-fluid gap-5">
                <div class="w-100 w-250px">
                    <label for="role_id" class="form-label">Role</label>
                    <select name="role_id" id="role_id" class="form-select form-select-lg " data-control="select2" data-placeholder="All"  data-placeholder="All" data-allow-clear="true" >
                        <option value="all">All</option>
                        @foreach ($role_list as $key => $value )
                        <option value="{{$value['id']}}">
                            {{$value['name']}}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="card-toolbar">
                @can('admin add')
                <a href="{{ route('add-admin') }}" class="btn btn-l fw-bold btn-primary" >
                    <i class="ki-duotone ki-plus-square fs-3">
                        <span class="path1"></span>
                        <span class="path2"></span>
                        <span class="path3"></span>
                    </i> Add Admin</a>
                @endcan
            </div>
        </div>

        <div class="card-body pt-0 classTable">
            <table class="table table-bordered " id="admin_list">
                <thead>
                    <tr class="text-start fw-bold fs-7 text-uppercase gs-0">
                        <th >#</th>
                        <th >Name</th>
                        <th >Email</th>
                        <th >Role</th>
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
