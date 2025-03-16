<?php

namespace App\Http\Controllers\backend\container;

use App\Http\Controllers\Controller;
use App\Models\Container;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ContainerController extends Controller
{
    public function index()
    {
        $data['title'] =  'Container List' . ' || ' . get_system_name();
        $data['header'] = array(
            'title' => 'Container List',
            'breadcrumb' => array(
                'Dashboard' => route('dashboard'),
                'Container List' => 'Container List',
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
            'validate/jquery.validate.min.js'
        );
        $data['widgetjs'] = array(
            'plugins/custom/datatables/table/datatables.bundle.js',
        );
        $data['js'] = array(
            'comman_function.js',
            'jquery.form.min.js',
            'container.js',
        );
        $data['funinit'] = array(
            'Container.init()'
        );

        return view('backend.pages.container.list', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['title'] =  'Container List' . ' || ' . get_system_name();
        $data['header'] = array(
            'title' => 'Container List',
            'breadcrumb' => array(
                'Dashboard' => route('dashboard'),
                'Container List' => 'Container List',
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
            'validate/jquery.validate.min.js'
        );
        $data['widgetjs'] = array(
            'plugins/custom/datatables/table/datatables.bundle.js',
        );
        $data['js'] = array(
            'comman_function.js',
            'jquery.form.min.js',
            'container.js',
        );
        $data['funinit'] = array(
            'Container.init()'
        );

        return view('backend.pages.container.list', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {

            $request->validate([
                'container_type' => 'required|unique:containers,container_type',
                // 'max_container' => 'required|integer|min:1',
                'max_capacity' => 'required|integer|min:1',
                'capacity_unit' => 'required|in:1,2', // 1=KG, 2=Tons
                'base_price' => 'required|numeric|min:1',
                'status' => 'required|in:1,2',
            ]);

            // Save new container
            Container::create([
                'container_type' => $request->container_type,
                // 'max_container' => $request->max_container,
                'max_capacity' => $request->max_capacity,
                'capacity_unit' => $request->capacity_unit,
                'base_price' => $request->base_price,
                'status' => $request->status,
                'add_by' => auth()->user()->id,
                'updated_by' => auth()->user()->id,
            ]);

            DB::commit();
            $return = [
                'status' => 'success',
                'message' => 'Container successfully added.',
                'jscode' => '$("#loader").hide();$("#add_container_modal").modal("hide");',
                'ajaxcall' => 'Container.init()'
            ];
        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();

            $errorMessages = '<ul>';
            foreach ($e->errors() as $error) {
                $errorMessages .= '<li class="text-start">' . implode('</li><li>', $error) . '</li>';
            }
            $errorMessages .= '</ul>';

            $return = [
                'sweet_alert' => 'sweet_alert',
                'status' => 'warning',
                'message' => $errorMessages, // Show all errors
                'jscode' => '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();',
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            $return['status'] = 'warning';
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

        DB::beginTransaction();
        try {
            // $request->validate([
            //     'container_type' => 'required|unique:containers,container_type,' . $request->edit_id,
            //     // 'max_container' => 'required|integer|min:1',
            //     'max_capacity' => 'required|integer|min:1',
            //     'capacity_unit' => 'required|in:1,2', // 1=KG, 2=Tons
            //     'base_price' => 'required|numeric|min:1',
            //     'status' => 'required|in:1,2',
            //     'updated_by' => auth()->user()->id,
            // ]);

            $findContainer = Container::find($request->edit_id);
            $findContainer->update([
                'container_type' => $request->container_type,
                // 'max_container' => $request->max_container,
                'max_capacity' => $request->max_capacity,
                'capacity_unit' => $request->capacity_unit,
                'base_price' => $request->base_price,
                'status' => $request->status,
            ]);

            DB::commit();

            $return = [
                'status' => 'success',
                'message' => 'Container successfully updated.',
                'jscode' => '$("#loader").hide();$("#edit_container_modal").modal("hide");',
                'ajaxcall' => 'Container.init()'
            ];
        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();

            $errorMessages = '<ul>';
            foreach ($e->errors() as $error) {
                $errorMessages .= '<li class="text-start">' . implode('</li><li>', $error) . '</li>';
            }
            $errorMessages .= '</ul>';

            $return = [
                'sweet_alert' => 'sweet_alert',
                'status' => 'warning',
                'message' => $errorMessages, // Show all validation errors
                'jscode' => '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();',
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            $return['status'] = 'warning';
            $return['jscode'] = '$("#loader").hide();';
            $return['message'] = 'Something goes to wrong.';
        }

        echo json_encode($return);
        exit;
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
                    1 => 'container_type',
                    // 2 => 'max_container',
                    2 => 'max_capacity',
                    3 => 'base_price',
                    4 => DB::raw('(CASE WHEN status = "1" THEN "Active" ELSE "Inactive" END)')
                );

                $query = Container::where('status', '!=', '3'); // no deleted

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

                $columnIndex = $requestData['order'][0]['column'];
                $columnSortOrder = $requestData['order'][0]['dir'];
                $columnName = $columns[$columnIndex];

                // if ($columnName === 'item_details') {

                // } else {
                $query->orderBy($columnName, $columnSortOrder);
                // }

                $totalData = $query->count();
                $totalFiltered = $query->count();

                $resultArr = $query->skip($requestData['start'])
                    ->take($requestData['length'])
                    ->get();

                $data = array();
                $i = 0;
                // ccd($resultArr);
                foreach ($resultArr as $row) {
                    $status = '';
                    $unit = '';
                    $actionhtml = '';
                    $actionhtml .= '<div class="dropdown">';
                    $actionhtml .= '<a href="javascript:;" class="menu-link px-3" id="dropdownMenuButton' . $row["id"] . '"                 data-bs-toggle="dropdown" aria-expanded="false">';
                    $actionhtml .= '<i style="font-size:1.3rem;" class="icon-xl fas fa-cog" title="Actions"></i>';
                    $actionhtml .= '</a>';
                    $actionhtml .= '<ul class="dropdown-menu dropdown-menu-lg px-3" aria-labelledby="dropdownMenuButton' . $row["id"] . '">';

                    if ($user->can('container edit')) {
                        $actionhtml .= '<li><a class="dropdown-item edit-container" href="javascript:;" data-id="' . $row["id"] . '"><i class="fa fa-edit text-warning"></i> Edit</a></li>';
                    }
                    if ($row['status'] == 1) {
                        $status = '<span class="badge py-1 px-4 fs-7 badge-light-success">Active</span>';
                        if ($user->can('container status')) {
                            $actionhtml .= '<li><a class="dropdown-item inactive-container" href="#" data-bs-toggle="modal" data-bs-target="#inactiveModal" data-id="' . $row["id"] . '"><i class="fa fa-times text-danger"></i> Inactive</a></li>';
                        }
                    } elseif ($row['status'] == 2) {
                        $status = '<span class="badge badge-light-danger py-1 px-4 fs-7 fs-base">Inactive</span>';
                        if ($user->can('container status')) {
                            $actionhtml .= '<li><a class="dropdown-item active-container" href="#" data-bs-toggle="modal" data-bs-target="#activeModal" data-id="' . $row["id"] . '"><i class="fa fa-check text-success"></i> Active</a></li>';
                        }
                    }
                    if ($user->can('container delete')) {
                        $actionhtml .= '<li><a class="dropdown-item delete-container" href="#" data-bs-toggle="modal" data-bs-target="#deleteModal" data-id="' . $row["id"] . '"><i class="fa fa-trash text-danger"></i> Delete</a></li>';
                    }
                    $actionhtml .= '</ul>';
                    $actionhtml .= '</div>';
                    

                    if ($row->capacity_unit == 1) {
                        $unit = '<span class="badge badge-outline badge-primary">KG</span>';
                    } else {
                        $unit = '<span class="badge badge-outline badge-primary">Tone</span>';
                    }

                    $i++;
                    $nestedData = array();
                    $nestedData[] = $i;
                    $nestedData[] = $row->container_type ?? 'N/A';
                    // $nestedData[] = $row->max_container ?? '0';
                    $nestedData[] = $row->max_capacity . ' ' . $unit  ?? '0';
                    $nestedData[] = $row->base_price ?? 'N/A';
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

            case 'add-container':

                $list = view('backend.pages.container.add');
                echo $list;
                break;

            case 'edit-container':

                $data['container_details'] = Container::find($request->container_id);
                // dd($data['permission_details']);
                $list = view('backend.pages.container.edit', $data);
                echo $list;
                break;

            case 'common-container':
                $data = $request->input('data');

                $findId = Container::find($data['id']);
                $result = $findId->update([
                    'status' => $data['type'],
                    'updated_by' => $user->id,
                    'updated_at' => Carbon::now(),
                ]);

                $statusMessages = [
                    1 => 'Container successfully activated.',
                    2 => 'Container successfully inactivated.',
                    3 => 'Container successfully deleted.',
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
                    $return['ajaxcall'] = 'Container.init()';
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
