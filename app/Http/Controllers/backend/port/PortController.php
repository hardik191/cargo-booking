<?php

namespace App\Http\Controllers\backend\port;

use App\Http\Controllers\Controller;
use App\Models\Port;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PortController extends Controller
{
    public function index()
    {
        $data['title'] =  'Port List' . ' || ' . get_system_name();
        $data['header'] = array(
            'title' => 'Port List',
            'breadcrumb' => array(
                'Dashboard' => route('dashboard'),
                'Port List' => 'Port List',
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
            'port.js',
        );
        $data['funinit'] = array(
            'Port.init()'
        );

        return view('backend.pages.port.list', $data);
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
        DB::beginTransaction();
        try {
            Port::create([
                'port_name' => $request->port_name,
                'location' => $request->location,
            ]);

            DB::commit();
            $return['status'] = 'success';
            $return['message'] = 'Port successfully added.';
            $return['jscode'] = '$("#loader").hide();';
            $return['redirect'] = route('subscription-settings');
        } catch (\Exception $e) {
            DB::rollBack();
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
    public function update(Request $request, string $id)
    {
        //
    }

    public function ajaxcall(Request $request)
    {
        $action = $request->input('action');
        $user = Auth::user();

        switch ($action) {
            case 'getdatatable':
                // ccd('df');
                $requestData = $_REQUEST;
                $columns = array(
                    0 => 'id',
                    1 => 'port_name',
                    2 => DB::raw('(CASE WHEN status = "1" THEN "Active" ELSE "Inactive" END)')
                );

                $query = Port::where('status', '!=', '3'); // no deleted

                if (!empty($requestData['search']['value'])) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
                    $searchVal = $requestData['search']['value'];
                    $query->where(function ($query) use ($columns, $searchVal, $requestData) {
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
                    $status = '';
                    $actionhtml = '';
                    $actionhtml .= '<div class="dropdown">';
                    $actionhtml .= '<a href="javascript:;" class="menu-link px-3" id="dropdownMenuButton' . $row["id"] . '"                 data-bs-toggle="dropdown" aria-expanded="false">';
                    $actionhtml .= '<i style="font-size:1.3rem;" class="icon-xl fas fa-cog" title="Actions"></i>';
                    $actionhtml .= '</a>';
                    $actionhtml .= '<ul class="dropdown-menu dropdown-menu-lg px-3" aria-labelledby="dropdownMenuButton' . $row["id"] . '">';

                    if ($user->can('port edit')) {
                        $actionhtml .= '<li><a class="dropdown-item edit-port" href="javascript:;" data-id="' . $row["id"] . '"><i class="fa fa-edit text-warning"></i> Edit</a></li>';
                    }
                    if ($row['status'] == 1) {
                        $status = '<span class="badge py-1 px-4 fs-7 badge-light-success">Active</span>';
                        if ($user->can('port status')) {
                            $actionhtml .= '<li><a class="dropdown-item inactive-notice" href="#" data-bs-toggle="modal" data-bs-target="#inactiveModal" data-id="' . $row["id"] . '"><i class="fa fa-times text-danger"></i> Inactive</a></li>';
                        }
                    } elseif ($row['status'] == 2) {
                        $status = '<span class="badge badge-light-danger py-1 px-4 fs-7 fs-base">Inactive</span>';
                        if ($user->can('port status')) {
                            $actionhtml .= '<li><a class="dropdown-item active-notice" href="#" data-bs-toggle="modal" data-bs-target="#activeModal" data-id="' . $row["id"] . '"><i class="fa fa-check text-success"></i> Active</a></li>';
                        }
                    }
                    if ($user->can('port delete')) {
                        $actionhtml .= '<li><a class="dropdown-item delete-notice" href="#" data-bs-toggle="modal" data-bs-target="#deleteModal" data-id="' . $row["id"] . '"><i class="fa fa-trash text-danger"></i> Delete</a></li>';
                    }
                    $actionhtml .= '</ul>';
                    $actionhtml .= '</div>';

                    $i++;
                    $nestedData = array();
                    $nestedData[] = $i;
                    $nestedData[] = $row->port_name;
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

            case 'add-port':

                $list = view('backend.pages.port.add');
                echo $list;
                break;

            case 'edit-notice':

                $data['notice_details'] = Notice::find($request->notice_id);
                // dd($data['permission_details']);
                $list = view('backend.pages.notice.edit', $data);
                echo $list;
                break;

            case 'common-notice':
                $data = $request->input('data');

                $findId = Notice::find($data['id']);
                $result = $findId->update([
                    'status' => $data['type'],
                    'updated_by' => $user->id,
                    'updated_at' => Carbon::now()->format('Y-m-d h:i:s'),
                ]);

                $statusMessages = [
                    1 => 'Notice successfully activated.',
                    2 => 'Notice successfully inactivated.',
                    3 => 'Notice successfully deleted.',
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
                    $return['ajaxcall'] = 'Notice.init()';
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
