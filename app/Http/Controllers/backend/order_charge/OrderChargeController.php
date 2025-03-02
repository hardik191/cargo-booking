<?php

namespace App\Http\Controllers\backend\order_charge;

use App\Http\Controllers\Controller;
use App\Models\OrderCharge;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class OrderChargeController extends Controller
{
    public function index()
    {
        $data['title'] =  'Order Charge List' . ' || ' . get_system_name();
        $data['header'] = array(
            'title' => 'Order Charge List',
            'breadcrumb' => array(
                'Dashboard' => route('dashboard'),
                'Order Charge List' => 'Order Charge List',
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
            'order_charge.js',
        );
        $data['funinit'] = array(
            'Order_charge.init()'
        );

        return view('backend.pages.order_charge.list', $data);
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
            $request->validate([
                'charge_name' => 'required|unique:order_charges,charge_name',
                'charge_value' => 'required|numeric|min:1',
                'charge_type' => 'required',
            ], [
                'charge_name.required' => 'The Charge Name field is required.',
                'charge_name.unique' => 'Charge Name already exists.',

                'charge_value.required' => 'The Charge Value field is required.',
                'charge_value.numeric' => 'The Charge Value must be a valid number.',
                'charge_value.min' => 'The Charge Value must be at least 1.',

                'charge_type.required' => 'The Charge Type field is required.',
            ]);

            OrderCharge::create([
                'charge_name' => $request->charge_name,
                'charge_type' => $request->charge_type,
                'charge_value' => $request->charge_value,
                'status' => $request->status ?? 1,
                'add_by' => auth()->user()->id,
                'updated_by' => auth()->user()->id,
            ]);

            DB::commit();

            $return = [
                'status' => 'success',
                'message' => 'Order Charge successfully added.',
                'jscode' => '$("#loader").hide();$("#add_order_charge_modal").modal("hide");',
                'ajaxcall' => 'Order_charge.init()'
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

            $request->validate([
                'charge_name' => 'required|unique:order_charges,charge_name,' . $request->edit_id,
                'charge_value' => 'required|numeric|min:1',
                'edit_charge_type' => 'required',
            ], [
                'charge_name.required' => 'The Charge Name field is required.',
                'charge_name.unique' => 'Charge Name already exists.',

                'charge_value.required' => 'The Charge Value field is required.',
                'charge_value.numeric' => 'The Charge Value must be a valid number.',
                'charge_value.min' => 'The Charge Value must be at least 1.',

                'edit_charge_type.required' => 'The Charge Type field is required.',
            ]);

            $findOrderCharge = OrderCharge::find($request->edit_id);
            $findOrderCharge->update([
                'charge_name' => $request->charge_name,
                'charge_type' => $request->edit_charge_type,
                'charge_value' => $request->charge_value,
                'status' => $request->status ?? 1,
                'updated_by' => auth()->user()->id,
            ]);

            DB::commit();

            $return = [
                'status' => 'success',
                'message' => 'Order Charge successfully updated.',
                'jscode' => '$("#loader").hide();$("#edit_order_charge_modal").modal("hide");',
                'ajaxcall' => 'Order_charge.init()'
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
                'message' => $errorMessages,
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
                    1 => 'charge_name',
                    2 => 'charge_value',
                    3 => DB::raw("
                        (CASE 
                            WHEN charge_type = '1' THEN 'Inhouse'
                            WHEN charge_type = '2' THEN 'Vendoring'
                            WHEN charge_type = '3' THEN 'Inhouse + Vendoring'
                            WHEN charge_type = '4' THEN 'Bought Out'
                            WHEN charge_type = '5' THEN 'Bought Out + Inhouse'
                            ELSE 'Unknown'
                        END)
                    "),
                    4 => DB::raw('(CASE WHEN status = "1" THEN "Active" ELSE "Inactive" END)')
                );

                $query = OrderCharge::where('status', '!=', '3'); // no deleted

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
                $chargeTypes = Config::get('constants.CHARGE_TYPE'); // Get charge type names

                foreach ($resultArr as $row) {
                    $status = '';
                    $charge_type_badge = '';
                    $actionhtml = '';
                    $actionhtml .= '<div class="dropdown">';
                    $actionhtml .= '<a href="javascript:;" class="menu-link px-3" id="dropdownMenuButton' . $row["id"] . '"                 data-bs-toggle="dropdown" aria-expanded="false">';
                    $actionhtml .= '<i style="font-size:1.3rem;" class="icon-xl fas fa-cog" title="Actions"></i>';
                    $actionhtml .= '</a>';
                    $actionhtml .= '<ul class="dropdown-menu dropdown-menu-lg px-3" aria-labelledby="dropdownMenuButton' . $row["id"] . '">';

                    if ($user->can('order-charge edit')) {
                        $actionhtml .= '<li><a class="dropdown-item edit-order-charge" href="javascript:;" data-id="' . $row["id"] . '"><i class="fa fa-edit text-warning"></i> Edit</a></li>';
                    }
                    if ($row['status'] == 1) {
                        $status = '<span class="badge py-1 px-4 fs-7 badge-light-success">Active</span>';
                        if ($user->can('order-charge status')) {
                            $actionhtml .= '<li><a class="dropdown-item inactive-order-charge" href="#" data-bs-toggle="modal" data-bs-target="#inactiveModal" data-id="' . $row["id"] . '"><i class="fa fa-times text-danger"></i> Inactive</a></li>';
                        }
                    } elseif ($row['status'] == 2) {
                        $status = '<span class="badge badge-light-danger py-1 px-4 fs-7 fs-base">Inactive</span>';
                        if ($user->can('order-charge status')) {
                            $actionhtml .= '<li><a class="dropdown-item active-order-charge" href="#" data-bs-toggle="modal" data-bs-target="#activeModal" data-id="' . $row["id"] . '"><i class="fa fa-check text-success"></i> Active</a></li>';
                        }
                    }
                    if ($user->can('order-charge delete')) {
                        $actionhtml .= '<li><a class="dropdown-item delete-order-charge" href="#" data-bs-toggle="modal" data-bs-target="#deleteModal" data-id="' . $row["id"] . '"><i class="fa fa-trash text-danger"></i> Delete</a></li>';
                    }
                    $actionhtml .= '</ul>';
                    $actionhtml .= '</div>';

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

                    $charge_type_badge = '<span class="badge badge-outline ' . $randomBadge . '">' . ($chargeTypes[$row->charge_type] ?? 'Unknown') . '</span>';

                    $i++;
                    $nestedData = array();
                    $nestedData[] = $i;
                    $nestedData[] = $row->charge_name;
                    $nestedData[] = $row->charge_value;
                    $nestedData[] = $charge_type_badge;
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

            case 'add-order-charge':

                $data['charge_type'] = Config::get('constants.CHARGE_TYPE');

                $list = view('backend.pages.order_charge.add', $data);
                echo $list;
                break;

            case 'edit-order-charge':
                $data['charge_type'] = Config::get('constants.CHARGE_TYPE');
                $data['order_charge_details'] = OrderCharge::find($request->order_charge_id);
                // dd($data['permission_details']);
                $list = view('backend.pages.order_charge.edit', $data);
                echo $list;
                break;

            case 'common-order-charge':
                $data = $request->input('data');

                $findId = OrderCharge::find($data['id']);
                $result = $findId->update([
                    'status' => $data['type'],
                    'updated_by' => $user->id,
                    'updated_at' => Carbon::now(),
                ]);

                $statusMessages = [
                    1 => 'Order Charge successfully activated.',
                    2 => 'Order Charge successfully inactivated.',
                    3 => 'Order Charge successfully deleted.',
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
                    $return['ajaxcall'] = 'Order_charge.init()';
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
