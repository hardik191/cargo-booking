<?php

namespace App\Http\Controllers\customer\order;

use App\Http\Controllers\Controller;
use App\Models\Container;
use App\Models\Order;
use App\Models\OrderCharge;
use App\Models\OrderChargeDetail;
use App\Models\OrderContainerDetail;
use App\Models\Port;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class PendingOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['title'] =  'Pending Order' . ' || ' . get_system_name();
        $data['header'] = array(
            'title' => 'Pending Order',
            'breadcrumb' => array(
                'Home' => route('dashboard'),
                'Create Order' => route('create-order'),
                'Pending Order' => 'Pending Order',
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
            // 'validate/jquery.validate.min.js',
        );
        $data['widgetjs'] = array(
            'plugins/custom/datatables/table/datatables.bundle.js',
        );
        $data['js'] = array(
            'comman_function.js',
            'jquery.form.min.js',
            'pending_order.js',
        );
        $data['funinit'] = array(
            'Pending_order.init()'
        );

        return view('customer.pages.order.pending_order.list', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['port_details'] = Port::where('status', '1')->get();
        $data['container_details'] = Container::where('status', '1')->get();
        $data['order_charge_details'] = OrderCharge::where('status', '1')->get();

        $data['chargeTypes'] = Config::get('constants.CHARGE_TYPE'); // Get charge type names

        $data['title'] =  'Create Order' . ' || ' . get_system_name();
        $data['header'] = array(
            'title' => 'Create Order',
            'breadcrumb' => array(
                'Home' => route('dashboard'),
                'Pending Order' => route('pending-order1'),
                'Create Order' => 'Create Order',
            )
        );

        $data['css'] = array(
            'toastr/toastr.min.css'
        );
        $data['plugincss'] = array(
            // 'plugins/custom/datatables/table/datatables.bundle.css',
        );
        $data['pluginjs'] = array(
            'toastr/toastr.min.js',
            'validate/jquery.validate.min.js',
        );
        $data['widgetjs'] = array(
            // 'plugins/custom/datatables/table/datatables.bundle.js',
        );
        $data['js'] = array(
            'comman_function.js',
            'jquery.form.min.js',
            'pending_order.js',
        );
        $data['funinit'] = array(
            'Pending_order.create()'
        );

        return view('customer.pages.order.order.add', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            // Validate the request data
            $request->validate([
                'sender_name' => 'required|string|max:255',
                'sender_email' => 'required|email|max:255',
                'sender_phone_no' => 'required|digits_between:8,15',
                'sender_port' => 'required|exists:ports,id',
                'receiver_name' => 'required|string|max:255',
                'receiver_email' => 'required|email|max:255',
                'receiver_phone_no' => 'required|digits_between:8,15',
                'receiver_port' => 'required|exists:ports,id',
                'total_qty' => 'required|numeric|min:1',
                'total_price' => 'required|numeric|min:0',
                'total_charge' => 'required|numeric|min:0',
                'final_total' => 'required|numeric|min:0',
                'my_order_qty' => 'required|array',
                'my_order_qty.*' => 'required|numeric|min:0',
                'my_capacity' => 'required|array',
                'my_capacity.*' => 'required|numeric|min:0',
                'sub_price' => 'required|array',
                'sub_price.*' => 'required|numeric|min:0',
                'charge_type' => 'required|array',
                'charge_type.*' => 'required|integer|min:0|max:5',
                'charge_value' => 'required|array',
                'charge_value.*' => 'required|numeric|min:0',
            ]);

            // Create a new order
            $order = Order::create([
                'sender_name' => $request->sender_name,
                'sender_email' => $request->sender_email,
                'sender_phone_no' => $request->sender_phone_no,
                'sender_port_id' => $request->sender_port,
                'receiver_name' => $request->receiver_name,
                'receiver_email' => $request->receiver_email,
                'receiver_phone_no' => $request->receiver_phone_no,
                'receiver_port_id' => $request->receiver_port,
                'total_capacity' => array_sum($request->my_capacity),
                'total_qty' => $request->total_qty,
                'total_price' => $request->total_price,
                'total_charge' => $request->total_charge,
                'final_total' => $request->final_total,
                'order_status' => 1, // Pending
                'payment_status' => 1, // Pending
                'add_by' => auth()->id(),
                'updated_by' => auth()->id(),
            ]);

            // Insert container details
            foreach ($request->my_order_qty as $index => $qty) {
                if ($qty > 0) {
                    $findContainer = Container::find($request->container_id[$index]);
                    OrderContainerDetail::create([
                        'order_id' => $order->id,
                        'container_id' => $request->container_id[$index],

                        'max_capacity' => $findContainer->max_capacity,
                        'capacity_unit' => $findContainer->capacity_unit,
                        'base_price' => $findContainer->base_price,

                        'my_order_qty' => $qty,
                        'my_capacity' => $request->my_capacity[$index],
                        'sub_price' => $request->sub_price[$index],
                        'add_by' => auth()->id(),
                        'updated_by' => auth()->id(),
                    ]);
                }
            }

            // Insert order charge details
            foreach ($request->charge_type as $index => $chargeType) {
                OrderChargeDetail::create([
                    'order_id' => $order->id,
                    'charge_id' => $request->charge_id[$index],
                    'charge_type' => $chargeType,
                    'charge_value' => $request->charge_value[$index],
                    'add_by' => auth()->id(),
                    'updated_by' => auth()->id(),
                ]);
            }

            DB::commit();

            $return = [
                'status' => 'success',
                'message' => 'Order successfully created.',
                'jscode' => '$("#loader").hide();',
                'redirect' =>  route('pending-order1'),
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
            throw $e;
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
                    1 => 'order_code',
                    2 => 'sender_name',
                    3 => '',
                    4 => 'final_total',
                    5 => DB::raw("
                        (CASE 
                            WHEN order_status = '1' THEN 'Pending'
                            WHEN order_status = '2' THEN 'Accepted'
                            WHEN order_status = '3' THEN 'Rejected'
                            WHEN order_status = '4' THEN 'Shipped'
                            WHEN order_status = '5' THEN 'Deliver'
                            ELSE 'Deliver'
                        END)
                    "),
                    6 => DB::raw("
                        (CASE 
                            WHEN payment_status = '1' THEN 'Pending'
                            WHEN payment_status = '2' THEN 'Successful'
                            WHEN payment_status = '3' THEN 'Cancelled'
                            ELSE 'Cancelled'
                        END)
                    "),
                );

                $query = Order::where('is_deleted', '1'); 

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

                if ($columnName == 'role.name') {
                    $query->with(['roles' => function ($q) use ($columnSortOrder) {
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

                $financialYearColors = [];
                $availableColors = ['#FF5733', '#33FF57', '#3375FF', '#FF33A8', '#FFD733']; // Define different colors

                foreach ($resultArr as $row) {
                    $actionhtml = '';

                    preg_match('/ORD-(\d{2}-\d{2})-/', $row->order_code, $matches);
                    $financialYear = $matches[1] ?? 'Unknown';

                    // Assign the same color to all orders of the same financial year
                    if (!isset($financialYearColors[$financialYear])) {
                        $financialYearColors[$financialYear] = array_shift($availableColors) ?? '#000000';
                    }

                    $orderColor = $financialYearColors[$financialYear];

                    $orderCodeBadge = '<span class="badge" style="background-color:' . $orderColor . '; color: #fff; padding: 5px 10px;">' . $row->order_code . '</span>';
 
                    $actionhtml .= '<div class="dropdown">';
                    $actionhtml .= '<a href="javascript:;" class="menu-link px-3" id="dropdownMenuButton' . $row["id"] . '"                 data-bs-toggle="dropdown" aria-expanded="false">';
                    $actionhtml .= '<i style="font-size:1.3rem;" class="icon-xl fas fa-cog" title="Actions"></i>';
                    $actionhtml .= '</a>';
                    $actionhtml .= '<ul class="dropdown-menu dropdown-menu-lg px-3" aria-labelledby="dropdownMenuButton' . $row["id"] . '">';

                    if ($user->can('order edit')) {
                        $actionhtml .= '<li><a class="dropdown-item " href="javascript:;" data-id="' . $row["id"] . '"><i class="fa fa-edit text-warning"></i> Edit</a></li>';
                    }
                    
                    $actionhtml .= '</ul>';
                    $actionhtml .= '</div>';

                    $sender_name = $row->sender_name ?? 'N/A';
                    $sender_email = $row->sender_email ?? 'N/A';
                    $sender_country_code = $row->sender_country_code ? '+'.$row->sender_country_code : '';
                    $sender_phone_no = $row->sender_phone_no ? $sender_country_code . ' ' . $row->sender_phone_no : 'N/A';

                    $receiver_name = $row->receiver_name ?? 'N/A';
                    $receiver_email = $row->receiver_email ?? 'N/A';
                    $receiver_country_code = $row->receiver_country_code ? '+'.$row->receiver_country_code : '';
                    $receiver_phone_no = $row->receiver_phone_no ? $receiver_country_code . ' ' . $row->receiver_phone_no : 'N/A';

                    $sender_details = '<div class="d-flex align-items-center">
                                        <div class="d-flex justify-content-start flex-column">
                                            <a href="' . route('view-pending-order1', $row['id']) . '" class="text-gray-800 fw-bold text-hover-primary mb-1 fs-6">' 
                                            . $sender_name . '</a>
                                            <span class="text-gray-500 fw-semibold d-block fs-7">' . $sender_email . '
                                            </span>
                                            <span class="text-gray-500 fw-semibold d-block fs-7">' . $sender_phone_no . '
                                            </span>
                                        </div>
                                    </div>';

                    $receiver_details = '<div class="d-flex align-items-center">
                                        <div class="d-flex justify-content-start flex-column">
                                            <a href="' . route('view-pending-order1', $row['id']) . '" class="text-gray-800 fw-bold text-hover-primary mb-1 fs-6">'
                                            . $receiver_name . '</a>
                                            <span class="text-gray-500 fw-semibold d-block fs-7">' . $receiver_email . '
                                            </span>
                                            <span class="text-gray-500 fw-semibold d-block fs-7">' . $receiver_phone_no . '
                                            </span>
                                        </div>
                                    </div>';

                    $paymentBadge = match ((int) $row->payment_status) {
                        1 => '<span class="badge badge-warning">Pending</span>',
                        2 => '<span class="badge badge-success">Successful</span>',
                        3 => '<span class="badge badge-danger">Cancelled</span>',
                        default => '<span class="badge badge-secondary">Unknown</span>',
                    };

                    $orderBadge = match ((int) $row->order_status) {
                        1 => '<span class="badge badge-outline badge-warning">Pending</span>',
                        2 => '<span class="badge badge-outline badge-primary">Accepted</span>',
                        3 => '<span class="badge badge-outline badge-danger">Rejected</span>',
                        4 => '<span class="badge badge-outline badge-info">Shipped</span>',
                        5 => '<span class="badge badge-outline badge-success">Delivered</span>',
                        default => '<span class="badge badge-outline badge-secondary">Unknown</span>',
                    };

                    $i++;
                    $nestedData = array();
                    $nestedData[] = $i;
                    $nestedData[] = $orderCodeBadge;
                    $nestedData[] = $sender_details;
                    $nestedData[] = $receiver_details;
                    $nestedData[] = $row->final_total;
                    $nestedData[] = $paymentBadge;
                    $nestedData[] = $orderBadge;
                    $nestedData[] = enterDateforment($row->created_at, 'd-m-Y H:i A');
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
            
        }
    }
}
