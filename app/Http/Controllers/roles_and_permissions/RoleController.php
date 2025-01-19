<?php

namespace App\Http\Controllers\roles_and_permissions;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Config;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use DB;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['title'] =  'Roles '.' || '.get_system_name();
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
            'role.js',
        );
        $data['funinit'] = array(
            'Role.init()'
        );
        $data['header'] = array(
            'title' => 'Role List',
            'breadcrumb' => array(
                'Dashboard' => route('dashboard'),
                'Roles List' => 'Roles List',
            )
        );

        return view('backend.pages.roles_and_permissions.roles.list', $data);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'role_name' => [
                'required',
                'string',
                'unique:roles,name'
            ],
            // 'permission' => 'required' ], [ 'permission.required' => 'Please select at least one permission.',
        ]);
        DB::beginTransaction();
        try {
            $role = Role::create([
                'name' => $request->role_name
            ]);

            if (isset($role)) {
                $role->syncPermissions($request->permission);
                DB::commit();
                $return = [
                    'status' => 'success',
                    'message' => 'Role successfully added.',
                    'jscode' => '$("#loader").hide();$("#add_role_modal").modal("hide");',
                    'ajaxcall' => 'Role.init()'
                ];
            } else {
                DB::rollback();
                $return['status'] = 'warning';
                $return['jscode'] = '$("#loader").hide();';
                $return['message'] = 'Something goes to wrong.';
            }
        } catch (\Exception $e) {
            DB::rollback();
            $return = [
                'status' => 'error',
                'jscode' => '$("#loader").hide();',
                'message' => 'Error:: ' . $e->getMessage(),
            ];
        }
        echo json_encode($return);
        exit;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $request->validate([
            'role_name' => [
                'required',
                'string',
                'unique:roles,name,'.$request->edit_id,
            ]
        ]);

        DB::beginTransaction();
        try {
            $role = Role::findOrFail($request->edit_id);

            $role_update = $role->update([
                'name' => $request->role_name,
                'updated_at' => Carbon::now(),
            ]);

            if (isset($role_update)) {

                $role->syncPermissions($request->permission);

                DB::commit();
                $return = [
                    'status' => 'success',
                    'message' => 'Role successfully updated.',
                    'jscode' => '$("#loader").hide();$("#edit_role_modal").modal("hide");',
                    'ajaxcall' => 'Role.init()'
                ];
            } else {
                DB::rollback();
                $return['status'] = 'warning';
                $return['jscode'] = '$("#loader").hide();';
                $return['message'] = 'Something goes to wrong.';
            }

        } catch (\Exception $e) {
            DB::rollback();
            $return = [
                'status' => 'error',
                'jscode' => '$("#loader").hide();',
                'message' => 'Error:: ' . $e->getMessage(),
            ];
        }
        echo json_encode($return);
        exit;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $role = Role::find($request->role_id);
        if(isset($role))
        {
            $result = $role->delete();
        }
        if (isset($result)) {
            $return['status'] = 'success';
            $return['message'] = 'Role successfully deleted.';
            $return['jscode'] = '$("#loader").hide();$("#deleteModal").modal("hide");';
            $return['redirect'] = route('roles');
        } else {
            $return['status'] = 'error';
            $return['jscode'] = '$("#loader").hide();';
            $return['message'] = 'Something goes to wrong.';
        }

        echo json_encode($return);
        exit;

    }

    public function ajaxcall(Request $request){

        $action = $request->input('action');
        $user = Auth::user();

        switch ($action) {
            case 'getdatatable':
                    // ccd($employee_list);
                    $requestData = $_REQUEST;
                    $columns = array(
                        0 => 'roles.id',
                        1 => 'roles.name',
                    );
                    $query = Role::from('roles');

                    if (!empty($requestData['search']['value'])) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
                        $searchVal = $requestData['search']['value'];
                        $query->where(function($query) use ($columns, $searchVal, $requestData) {
                            $flag = 0;
                            foreach ($columns as $key => $value) {
                                $searchVal = $requestData['search']['value'];
                                if ($requestData['columns'][$key]['searchable'] == 'true') {
                                    if ($flag == 0) {
                                        $query->where($value, 'like', '%' . $searchVal . '%');
                                        $flag = $flag + 1;
                                    } else {
                                        $query->orWhere($value, 'like', '%' . $searchVal . '%');
                                    }
                                }
                            }
                        });
                    }

                    $temp = $query->orderBy($columns[$requestData['order'][0]['column']], $requestData['order'][0]['dir']);

                    $totalData = count($temp->get());
                    $totalFiltered = count($temp->get());

                    $resultArr = $query->skip($requestData['start'])
                                ->take($requestData['length'])
                                ->get();

                    $data = array();
                    $i = 0;
                    // ccd($resultArr);
                    foreach ($resultArr as $row) {
                        $actionhtml = '';
                        $actionhtml .= '<div class="dropdown">';
                        $actionhtml .= '<a href="javascript:;" class="menu-link px-3" id="dropdownMenuButton' . $row["id"] . '"                 data-bs-toggle="dropdown" aria-expanded="false">';
                        $actionhtml .= '<i class="fs-2x icon-xl fas fa-cog" title="Actions"></i>';
                        $actionhtml .= '</a>';
                        $actionhtml .= '<ul class="dropdown-menu dropdown-menu-lg px-3" aria-labelledby="dropdownMenuButton' . $row["id"] . '">';

                            // if($user->can('role edit'))
                            //     {
                                   $actionhtml .= '<li><a class="dropdown-item edit-role" href="javascript:;" data-id="' . $row["id"] . '"><i class="fa fa-edit text-warning"></i> Edit </a></li>';
                                // }
                            // if($user->can('role delete')){
                            //    $actionhtml .= '<li><a class="dropdown-item delete-role" href="#" data-bs-toggle="modal" data-bs-target="#deleteModal" data-id="' . $row["id"] . '"><i class="fa fa-trash text-danger"></i> Delete </a></li>';
                            // }


                        $actionhtml .= '</ul>';
                        $actionhtml .= '</div>';

                        $i++;
                        $nestedData = array();
                        $nestedData[] = $i;
                        $nestedData[] = ucwords($row['name']);
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

                case 'add-role':
                    $permissions = Permission::all();
                    $groupedPermissions = $permissions->groupBy(function($permission) {
                        $firstWord = explode(' ', $permission->name)[0];
                        return $firstWord;
                    });

                    $data['permissions_list'] = $groupedPermissions->filter(function($group) {
                        return $group->count() > 0;
                    });
                    $list = view('backend.pages.roles_and_permissions.roles.add', $data);
                echo $list;
                break;

                case 'edit-role':
                    $permissions = Permission::all();
                    $groupedPermissions = $permissions->groupBy(function($permission) {
                        $firstWord = explode(' ', $permission->name)[0];
                        return $firstWord;
                    });

                    $data['permissions_list'] = $groupedPermissions->filter(function($group) {
                        return $group->count() > 0;
                    });
                    $data['role_details'] = Role::find($request->role_id);
                    $data['assign_permissions'] = $data['role_details']->getPermissionNames();

                    $list = view('backend.pages.roles_and_permissions.roles.edit', $data);
                echo $list;
                break;

        }
    }
}
