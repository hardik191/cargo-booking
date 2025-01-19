<?php

namespace App\Http\Controllers\roles_and_permissions;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Config;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $data['title'] =  'Permissions '.' || '.get_system_name();
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
            'permission.js',
        );
        $data['funinit'] = array(
            'Permission.init()'
        );
        $data['header'] = array(
            'title' => 'Permissions',
            'breadcrumb' => array(
                'Dashboard' => route('dashboard'),
                'Permissions List' => 'Permission List',
            )
        );
        // $user = Auth::user();
        // if ($user->can('edit articles')) {
            return view('backend.pages.roles_and_permissions.permissions.list', $data);
        // } else {
        //     $return['status'] = 'warning';
        //     $return['message'] = 'Permission not access.';
        //     $return['jscode'] = '$("#loader").hide();';
        //     $return['redirect'] =  route('dashboard');

        // }

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
        // echo "<pre>"; print_r($request->all()); die();
        $request->validate([
            'permission_name' => [
                'required',
                'string',
                'unique:permissions,name'
            ]
        ]);

        $result = Permission::create([
            'name' => $request->permission_name
        ]);

        if (isset($result)) {
            $return['status'] = 'success';
            $return['message'] = 'Permission successfully added.';
            $return['jscode'] = '$("#loader").hide();$("#add_permission_modal").modal("hide");';
            $return['ajaxcall'] = 'Permission.init()';
        } else {
            $return['status'] = 'error';
            $return['jscode'] = '$("#loader").hide();';
            $return['message'] = 'Something goes to wrong.';
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
            'permission_name' => [
                'required',
                'string',
                'unique:permissions,name,'.$request->edit_id,
            ]
        ]);

        $role = Permission::findOrFail($request->edit_id);
        $result = $role->update([
            'name' => $request->permission_name,
            'updated_at' => Carbon::now(),
        ]);

        if (isset($result)) {
            $return['status'] = 'success';
            $return['message'] = 'Permission successfully updated.';
            $return['jscode'] = '$("#loader").hide();$("#edit_permission_modal").modal("hide");';
            $return['ajaxcall'] = 'Permission.init()';
        } else {
            $return['status'] = 'error';
            $return['jscode'] = '$("#loader").hide();';
            $return['message'] = 'Something goes to wrong.';
        }

        echo json_encode($return);
        exit;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $permission = Permission::find($request->permission_id);
        if(isset($permission))
        {
            $result = $permission->delete();
        }

        if (isset($result)) {
            $return['status'] = 'success';
            $return['message'] = 'Permission successfully deleted.';
            $return['jscode'] = '$("#loader").hide();$("#deleteModal").modal("hide");';
            $return['redirect'] = route('permissions');
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

        switch ($action) {
            case 'getdatatable':
                    // ccd($employee_list);
                    $requestData = $_REQUEST;
                    $columns = array(
                        0 => 'permissions.id',
                        1 => 'permissions.name',
                        2 => 'permissions.name',
                    );
                    $query = Permission::from('permissions');

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
                    $user = Auth::user();
                    foreach ($resultArr as $row) {
                        $actionhtml = '';
                        $actionhtml .= '<div class="dropdown">';
                        $actionhtml .= '<a href="javascript:;" class="menu-link px-3" id="dropdownMenuButton' . $row["id"] . '"                 data-bs-toggle="dropdown" aria-expanded="false">';
                        $actionhtml .= '<i class="fs-2x icon-xl fas fa-cog" title="Actions"></i>';
                        $actionhtml .= '</a>';
                        $actionhtml .= '<ul class="dropdown-menu dropdown-menu-lg px-3" aria-labelledby="dropdownMenuButton' . $row["id"] . '">';

                        // if($user->can('permission edit'))
                        // {
                            // $actionhtml .= '<li><a class="dropdown-item edit-permission" href="javascript:;" data-id="' . $row["id"] . '"><i class="fa fa-edit text-warning"></i> Edit</a></li>';
                        // }
                        // if($user->can('permission delete')){
                        //        $actionhtml .= '<li><a class="dropdown-item delete-permission" href="#" data-bs-toggle="modal" data-bs-target="#deleteModal" data-id="' . $row["id"] . '"><i class="fa fa-trash text-danger"></i> Delete</a></li>';
                        // }


                        $actionhtml .= '</ul>';
                        $actionhtml .= '</div>';

                        $nameParts = explode(' ', $row['name']);
                        $label = str_replace('-', ' ', $nameParts[0]);
                        $remainingName = implode(' ', array_slice($nameParts, 1));
                        $formattedName = $remainingName;

                        $i++;
                        $nestedData = array();
                        $nestedData[] = $i;
                        // $nestedData[] = $row['id'];
                        $nestedData[] = ucfirst($label);
                        $nestedData[] = ucfirst($formattedName);
                        // $nestedData[] = $actionhtml;
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

                case 'add-permission':

                    $list = view('backend.pages.roles_and_permissions.permissions.add');
                echo $list;
                break;

                case 'edit-permission':

                    $data['permission_details'] = Permission::find($request->permission_id);
                    // dd($data['permission_details']);
                    $list = view('backend.pages.roles_and_permissions.permissions.edit', $data);
                echo $list;
                break;
        }
    }
}
