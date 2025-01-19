<?php

namespace App\Http\Controllers\backend\user_management;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['title'] =  'Customer List'.' || '.get_system_name();
        $data['header'] = array(
            'title' => 'Customer List',
            'breadcrumb' => array(
                'Dashboard' => route('dashboard'),
                'Customer List' => 'Customer List',
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
            'customer.js',
        );
        $data['funinit'] = array(
            'Customer.init()'
        );

        return view('backend.pages.user_management.customer.list', $data);
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
        //
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
    public function update(Request $request, string $id)
    {
        //
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
                    3 => 'users.phone_no',
                    4 => 'users.created_at',
                    5 => DB::raw('(CASE WHEN users.status = "1" THEN "Active" ELSE "Inactive" END)'),
                );

                $query = User::with('roles')
                    ->where('status', '!=', '3')
                    ->whereHas('roles', function ($query) {
                        $query->where('name', 'Customer');
                    });

                if (!empty($requestData['search']['value'])) {
                    $searchVal = $requestData['search']['value'];
                    $query->where(function ($query) use ($columns, $searchVal, $requestData) {
                        foreach ($columns as $key => $column) {
                            if ($requestData['columns'][$key]['searchable'] === 'true') {
                                if ($column === 'category_details.category_name') {
                                    // $query->orWhereHas('category_details', function ($q) use ($searchVal) {
                                    //     $q->where('category_name', 'like', '%' . $searchVal . '%');
                                    // });
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

                if ($columnName == 'category_details.category_name') {
                    // $query->orderBy(Category::select('category_name')
                    //         ->whereColumn('categories.id', 'sub_categories.category_id'),$columnSortOrder);
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


                    if ($user->can('customer view')) {
                        $actionhtml .= '<li><a class="dropdown-item" href="' . route('view-customer', $row['id']) . '" ><i class="fa fa-eye text-info"></i>View</a></li>';
                    }

                    if ($row['status'] == 1) {
                        $status = '<span class="badge py-1 px-4 fs-7 badge-light-success">Active</span>';
                        if ($user->can('customer status')) {
                            $actionhtml .= '<li><a class="dropdown-item inactive-user" href="javascript:;" data-bs-toggle="modal" data-bs-target="#inactiveModal" data-id="' . $row["id"] . '"><i class="fa fa-times text-danger"></i> Inactive</a></li>';
                        }
                    } elseif ($row['status'] == 2) {
                        $status = '<span class="badge badge-light-danger py-1 px-4 fs-7 fs-base">Inactive</span>';
                        if ($user->can('customer status')) {
                            $actionhtml .= '<li><a class="dropdown-item active-user" href="javascript:;" data-bs-toggle="modal" data-bs-target="#activeModal" data-id="' . $row["id"] . '"><i class="fa fa-check text-success"></i> Active</a></li>';
                        }
                    }
                    if ($user->can('customer delete')) {
                        $actionhtml .= '<li><a class="dropdown-item delete-user" href="javascript:;" data-bs-toggle="modal" data-bs-target="#deleteModal" data-id="' . $row["id"] . '"><i class="fa fa-trash text-danger"></i> Delete</a></li>';
                    }


                    $actionhtml .= '</ul>';
                    $actionhtml .= '</div>';

                    $i++;
                    $nestedData = array();
                    $nestedData[] = $i;
                    // $nestedData[] = $row['id'];
                    $nestedData[] = $row['name'] ?? 'N/A';
                    $nestedData[] = $row['email'] ?? 'N/A';
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
                        1 => 'Customer successfully activated.',
                        2 => 'Customer successfully inactivated.',
                        3 => 'Customer successfully deleted.',
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
                        $return['ajaxcall'] = 'Customer.init()';
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
