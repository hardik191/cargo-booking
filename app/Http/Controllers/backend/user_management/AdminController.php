<?php

namespace App\Http\Controllers\backend\user_management;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['role_list'] = Role::whereNotIn('name', ['Customer'])->get();

        $data['title'] =  'Admin List'.' || '.get_system_name();
        $data['header'] = array(
            'title' => 'Admin List',
            'breadcrumb' => array(
                'Dashboard' => route('dashboard'),
                'Admin List' => 'Admin List',
            )
        );
        $data['css'] = array(
            'toastr/toastr.min.css'
        );
        $data['plugincss'] = array(
            'plugins/custom/datatables/table/datatables.bundle.css',
        );
        $data['pluginjs'] = array(
            'toastr/toastr.min.js',
        );
        $data['widgetjs'] = array(
            'plugins/custom/datatables/table/datatables.bundle.js',
        );
        $data['js'] = array(
            'comman_function.js',
            'jquery.form.min.js',
            'admin.js',
        );
        $data['funinit'] = array(
            'Admin.init()'
        );

        return view('backend.pages.user_management.admin.list', $data);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['roles'] = Role::whereNotIn('name', ['Customer'])->get();

        $data['title'] =  'Add Admin' . ' || ' .get_system_name();
        $data['header'] = array(
            'title' => 'Add Admin',
            'breadcrumb' => array(
                'Home' => route('dashboard'),
                'Admin List' => route('admin-list'),
                'Add Admin' => 'Add Admin',
            )
        );
        $data['css'] = array(
            'toastr/toastr.min.css'
        );
        $data['plugincss'] = array();
        $data['pluginjs'] = array(
            'toastr/toastr.min.js',
            'validate/jquery.validate.min.js',
        );
        $data['js'] = array(
            'comman_function.js',
            'jquery.form.min.js',
            'admin.js',
        );
        $data['funinit'] = array(
            'Admin.add()'
        );

        return view('backend.pages.user_management.admin.add', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        $checkEmail = User::where('email', $request->email)->count();
        $checkPhoneNo = User::where('phone_no', $request->phone_no)
                        ->where('country_code', $request->country_code)->count();

        if($checkEmail != 0){
            $return['status'] = 'warning';
            $return['jscode'] = '$("#loader").hide();';
            $return['message'] = 'The email is already taken.';
        }else if($checkPhoneNo != 0){
            $return['status'] = 'warning';
            $return['jscode'] = '$("#loader").hide();';
            $return['message'] = 'The phone is already taken.';
        } else {
            try {
                DB::beginTransaction();

                // Create the user
                $user = User::create([
                    'name' => $request['name'],
                    'email' => $request['email'],
                    'phone_no' => $request['phone_no'],
                    'country_code' => $request['country_code'],
                    'password' => Hash::make($request['password']),
                    'status' => 1,
                ]);

                // Assign the role
                $user->assignRole($request['role']);

                DB::commit();
                $return['status'] = 'success';
                $return['message'] = 'Admin successfully added.';
                $return['jscode'] = '$("#loader").hide();';
                $return['redirect'] = route('admin-list');
            } catch (\Exception $e) {
                // If an error occurs
                DB::rollback();
                $return['status'] = 'error';
                $return['jscode'] = '$("#loader").hide();';
                $return['message'] = 'Something goes to wrong.';
            }
        }
        echo json_encode($return);
        exit;
    }

    /**
     * Display the specified resource.
     */
    public function show( $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $data['roles'] = Role::whereNotIn('name', ['Customer'])->get();
        $data['user_list'] = User::where('id', $id)->first();
        // dd($data);
        $data['title'] =  'Edit Admin' . ' || ' .get_system_name();
        $data['header'] = array(
            'title' => 'edit Admin',
            'breadcrumb' => array(
                'Home' => route('dashboard'),
                'Edit List' => route('admin-list'),
                'Edit Admin' => 'Edit Admin',
            )
        );
        $data['css'] = array(
            'toastr/toastr.min.css'
        );
        $data['plugincss'] = array();
        $data['pluginjs'] = array(
            'toastr/toastr.min.js',
            'validate/jquery.validate.min.js',
        );
        $data['js'] = array(
            'comman_function.js',
            'jquery.form.min.js',
            'admin.js',
        );
        $data['funinit'] = array(
            'Admin.edit()'
        );

        return view('backend.pages.user_management.admin.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $checkEmail = User::where('id', '!=', $request->edit_id)->where('email', $request->email)->count();
        $checkPhoneNo = User::where('id', '!=', $request->edit_id)
                        ->where('phone_no', $request->phone_no)
                        ->where('country_code', $request->country_code)->count();

        if($checkEmail != 0){
            $return['status'] = 'warning';
            $return['jscode'] = '$("#loader").hide();';
            $return['message'] = 'The email is already taken.';
        }else if($checkPhoneNo != 0){
            $return['status'] = 'warning';
            $return['jscode'] = '$("#loader").hide();';
            $return['message'] = 'The phone is already taken.';
        } else {
            try {
                DB::beginTransaction();
            
                // Update the user if edit_id is present
                $user = User::find($request->edit_id);
                // $user = User::where('id', $request->edit_id)->orWhere('sd', '$fsdf')->first();
    
                $user->update([
                    'name' => $request->name,
                    'email' => $request['email'],
                    'phone_no' => $request['phone_no'],
                    'country_code' => $request['country_code'],
                    // Only update the password if it's provided
                    'password' => $request['password'] ? Hash::make($request['password']) : $user->password,
                    'status' => $request['status'] ?? $user->status, // Default to existing status if not provided
                ]);
        
                // Update the role if provided
                if ($request['role']) {
                    $user->syncRoles([$request['role']]); // Replace current roles with the new role
                }           
            
                DB::commit();
            
                $return['status'] = 'success';
                $return['message'] = 'Admin successfully updated.';
                $return['jscode'] = '$("#loader").hide();';
                $return['redirect'] = route('admin-list');
            } catch (\Exception $e) {
                // If an error occurs
                DB::rollback();
                $return['status'] = 'error';
                $return['jscode'] = '$("#loader").hide();';
                $return['message'] = 'Something went wrong.';
                $return['error'] = $e->getMessage(); // Optional: include the exception message for debugging
            }
        }
        echo json_encode($return);
        exit;
        
    }

    public function ajaxcall(Request $request){

        $action = $request->input('action');
        $user = Auth::user();
        switch ($action) {
            case 'getdatatable':
                // dd('cc');
                $requestData = $_REQUEST;
                $columns = array(
                    0 => 'users.id',
                    1 => 'users.name',
                    2 => 'users.email',
                    3 => 'role.name',
                    4 => 'users.phone_no',
                    5 => 'users.created_at',
                    6 => DB::raw('(CASE WHEN users.status = "1" THEN "Active" ELSE "Inactive" END)'),
                );

                $query = User::with('roles')
                    ->where('status', '!=', '3')
                    ->whereHas('roles', function ($query) {
                        $query->where('name', '!=', 'Customer');
                    });

                    $roleId = $request->input('data')['role_id'];
                if ($roleId && $roleId != 'all' && $roleId != '') {
                    $query->whereHas('roles', function ($q) use ($roleId) {
                        $q->where('id', $roleId);
                    });
                }

                if (!empty($requestData['search']['value'])) {
                    $searchVal = $requestData['search']['value'];
                    $query->where(function ($query) use ($columns, $searchVal, $requestData) {
                        foreach ($columns as $key => $column) {
                            if ($requestData['columns'][$key]['searchable'] === 'true') {
                                if ($column === 'role.name') {
                                    $query->orWhereHas('roles', function ($q) use ($searchVal) {
                                        $q->where('name', 'like', '%' . $searchVal . '%');
                                    });
                                } else {
                                    $query->orWhere($column, 'like', '%' . $searchVal . '%');
                                }
                            }
                        }
                    });
                }

                $columnIndex = $requestData['order'][0]['column'];
                $columnSortOrder = $requestData['order'][0]['dir'];
                $columnName = $columns[$columnIndex];

                if ($columnName == 'role.name') {
                    $query->with(['roles' => function($q) use ($columnSortOrder) {
                        $q->orderBy('name', $columnSortOrder);
                    }]);
                } else {
                    $query->orderBy($columnName, $columnSortOrder);
                }

                $totalData = $query->count();
                $totalFiltered = $query->count();

                // DB::enableQueryLog();
                $resultArr = $query->skip($requestData['start'])
                                ->take($requestData['length'])
                                ->get();
                // dd(DB::getQueryLog());
                $data = array();
                $i = 0;

                foreach ($resultArr as $row) {

                    $status = '';
                    $actionhtml = '';
                    $actionhtml .= '<div class="dropdown">';
                    $actionhtml .= '<a href="javascript:;" class="menu-link px-3" id="dropdownMenuButton' . $row["id"] . '" data-bs-toggle="dropdown" aria-expanded="false">';
                    $actionhtml .= '<i class="fs-2x icon-xl fas fa-cog" title="Actions"></i>';
                    $actionhtml .= '</a>';
                    $actionhtml .= '<ul class="dropdown-menu dropdown-menu-lg px-3" aria-labelledby="dropdownMenuButton' . $row["id"] . '">';

                    if ($user->can('admin edit')) {
                        $actionhtml .= '<li><a class="dropdown-item" href="' . route('edit-admin',  $row["id"]) . '" ><i class="fa fa-edit text-warning"></i>Edit</a></li>';
                    }

                    // if ($user->can('admin view')) {
                    //     $actionhtml .= '<li><a class="dropdown-item" href="' . route('view-customer', $row['id']) . '" ><i class="fa fa-eye text-info"></i>View</a></li>';
                    // }

                    if ($row['status'] == 1) {
                        $status = '<span class="badge py-1 px-4 fs-7 badge-light-success">Active</span>';
                        if ($user->can('admin status')) {
                            $actionhtml .= '<li><a class="dropdown-item inactive-user" href="javascript:;" data-bs-toggle="modal" data-bs-target="#inactiveModal" data-id="' . $row["id"] . '"><i class="fa fa-times text-danger"></i> Inactive</a></li>';
                        }
                    } elseif ($row['status'] == 2) {
                        $status = '<span class="badge badge-light-danger py-1 px-4 fs-7 fs-base">Inactive</span>';
                        if ($user->can('admin status')) {
                            $actionhtml .= '<li><a class="dropdown-item active-user" href="javascript:;" data-bs-toggle="modal" data-bs-target="#activeModal" data-id="' . $row["id"] . '"><i class="fa fa-check text-success"></i> Active</a></li>';
                        }
                    }
                    if ($user->can('admin delete')) {
                        $actionhtml .= '<li><a class="dropdown-item delete-user" href="javascript:;" data-bs-toggle="modal" data-bs-target="#deleteModal" data-id="' . $row["id"] . '"><i class="fa fa-trash text-danger"></i> Delete</a></li>';
                    }


                    $actionhtml .= '</ul>';
                    $actionhtml .= '</div>';

                    $roleNames = $row['roles']->pluck('name')->toArray();

                    $i++;
                    $nestedData = array();
                    $nestedData[] = $i;
                    // $nestedData[] = $row['id'];
                    $nestedData[] = $row['name'] ?? 'N/A';
                    $nestedData[] = $row['email'] ?? 'N/A';
                    $nestedData[] = ucwords(implode(', ', $roleNames));
                    $nestedData[] = $row['phone_no'] ?? 'N/A';
                    $nestedData[] = date_formate($row['created_at']);
                    $nestedData[] = $status;
                    $nestedData[] = $actionhtml;
                    $data[] = $nestedData;
                }
                $json_data = array(
                    "draw" => intval($requestData['draw']), // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw.
                    "recordsTotal" => intval($totalData), // total number of records
                    "recordsFiltered" => intval($totalFiltered), // total number of records after searching, if there is no searching then totalFiltered = totalData
                    "data" => $data   // total data array
                );

                echo json_encode($json_data);
                break;

                case "common-user":
                    $data = $request->input('data');

                    $findId = User::find($data['id']);
                    $result = $findId->update([
                        'status' => $data['type'],
                        'updated_by' => $user->id,
                        'updated_at' => Carbon::now()->format('Y-m-d h:i:s'),
                    ]);

                    $statusMessages = [
                        1 => 'Admin successfully activated.',
                        2 => 'Admin successfully inactivated.',
                        3 => 'Admin successfully deleted.',
                    ];

                    $modalSelectors = [
                        1 => 'activeModal',
                        2 => 'inactiveModal',
                        3 => 'deleteModal',
                    ];

                    if (isset($result)) {
                        $return['status'] = 'success';
                        $return['message'] = $statusMessages[$data['type']];
                        $return['jscode'] = '$("#loader").hide();$("#' . $modalSelectors[$data['type']] . '").modal("hide");';
                        $return['ajaxcall'] = 'Admin.init()';
                    } else {
                        $return['status'] = 'error';
                        $return['jscode'] = '$("#loader").hide();';
                        $return['message'] = 'Something went wrong.';
                    }

                    echo json_encode($return);
                    exit;

        }
    }

}
