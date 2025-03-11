<?php

namespace App\Http\Controllers\customer\order;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Port;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class AcceptedOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['port_details'] = Port::where('status', '1')->get();
        $user = Auth::user();

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
            'accepted_order.js',
        );
        $data['funinit'] = array(
            'Accepted_order.init()'
        );

        if ($user->hasRole('Customer')) {
            $data['title'] =  'Accepted Order List' . ' || ' . get_system_name();
            $data['header'] = array(
                'title' => 'Accepted Order List',
                'breadcrumb' => array(
                    'Home' => route('dashboard1'),
                    'Create Order' => route('create-order'),
                    'Accepted Order List' => 'Accepted Order List',
                )
            );
            return view('customer.pages.order.accepted_order.list', $data);
        } else {
            if ($user->can('accepted-order list')) {
                $data['title'] =  'Accepted Order List' . ' || ' . get_system_name();
                $data['header'] = array(
                    'title' => 'Accepted Order List',
                    'breadcrumb' => array(
                        'Home' => route('dashboard'),
                        'Accepted Order List' => 'Accepted Order List',
                    )
                );
                return view('customer.pages.order.accepted_order.list', $data);
            } else {
                return redirect()->route('access-denied');
            }
        }
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
    public function show($id)
    {
        $user = Auth::user();
        if ($user->hasRole('Customer')) {
            $data['order_details'] = Order::with(['orderContainerDetailMany', 'orderChargeDetailMany'])->where('add_by', $user->id)->where('id', $id)->first();

            $data['title'] =  'Accepted Order View' . ' || ' . get_system_name();
            $data['header'] = array(
                'title' => 'Accepted Order View',
                'breadcrumb' => array(
                    'Home' => route('dashboard1'),
                    'Accepted Order' => route('accepted-order1'),
                    'Accepted Order View' => 'Accepted Order View',
                )
            );
        } else {
            $data['order_details'] = Order::with(['orderContainerDetailMany', 'orderChargeDetailMany'])->where('id', $id)->first();

            $data['title'] =  'Accepted Order View' . ' || ' . get_system_name();
            $data['header'] = array(
                'title' => 'Accepted Order View',
                'breadcrumb' => array(
                    'Home' => route('dashboard'),
                    'Accepted Order' => route('accepted-order'),
                    'Accepted Order View' => 'Accepted Order View',
                )
            );
        }

        if (is_null($data['order_details'])) {
            if ($user->hasRole('Customer')) {
                return redirect()->route('accepted-order1')->with('warning', 'Order not found.');
            } else {
                return redirect()->route('accepted-order')->with('warning', 'Order not found.');
            }
        }

        $data['chargeTypes'] = Config::get('constants.CHARGE_TYPE'); // Get charge type names

        // $data['container_details'] = Container::where('status', '1')->get();
        // $data['order_charge_details'] = OrderCharge::where('status', '1')->get();

        $data['css'] = array(
            'toastr/toastr.min.css'
        );
        $data['plugincss'] = array(
            // 'plugins/custom/datatables/table/datatables.bundle.css',
        );
        $data['pluginjs'] = array(
            'toastr/toastr.min.js',
            // 'validate/jquery.validate.min.js',
        );
        $data['widgetjs'] = array(
            // 'plugins/custom/datatables/table/datatables.bundle.js',
        );
        $data['js'] = array(
            'comman_function.js',
            'jquery.form.min.js',
            'accepted_order.js',
        );
        $data['funinit'] = array(
            // 'Accepted_order.view()'
        );

        if ($user->hasRole('Customer')) {
            return view('customer.pages.order.accepted_order.view', $data);
        } else {
            if ($user->can('accepted-order view')) {
                return view('customer.pages.order.accepted_order.view', $data);
            } else {
                return redirect()->route('access-denied');
            }
        }
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
                    3 => 'receiver_name',
                    4 => 'final_total',
                    5 => DB::raw("
                        (CASE 
                            WHEN payment_status = '1' THEN 'Pending'
                            WHEN payment_status = '2' THEN 'Successful'
                            WHEN payment_status = '3' THEN 'Cancelled'
                            ELSE 'Cancelled'
                        END)
                    "),
                    // 6 => DB::raw("
                    //     (CASE 
                    //         WHEN order_status = '1' THEN 'Pending'
                    //         WHEN order_status = '2' THEN 'Accepted'
                    //         WHEN order_status = '3' THEN 'Rejected'
                    //         WHEN order_status = '4' THEN 'Shipped'
                    //         WHEN order_status = '5' THEN 'Delivery'
                    //         ELSE 'Delivery'
                    //     END)
                    // "),
                    6 => 'created_at',
                );

                if ($user->hasRole('Customer')) {
                    $query = Order::where('is_deleted', '1')->where('order_status', '2')->where('add_by', $user->id);
                } else {
                    $query = Order::where('is_deleted', '1')->where('order_status', '2');
                }

                if (!empty($request->input('data')['sender_port']) && $request->input('data')['sender_port'] != 'all') {
                    $query->where('sender_port_id', $request->input('data')['sender_port']);
                }
                if (!empty($request->input('data')['receiver_port']) && $request->input('data')['receiver_port'] != 'all') {
                    $query->where('receiver_port_id', $request->input('data')['receiver_port']);
                }

                if (!empty($requestData['search']['value'])) {
                    $searchVal = $requestData['search']['value'];
                    $query->where(function ($query) use ($columns, $searchVal, $requestData) {
                        foreach ($columns as $key => $column) {
                            if ($requestData['columns'][$key]['searchable'] === 'true') {

                                // if ($column == 'store_items.item_name') {
                                //     $query->orWhereHas('jobCardId.WorkOrder.store_items', function ($q) use ($searchVal) {
                                //         $q->where('item_name', 'like', '%' . $searchVal . '%')
                                //             ->orWhere('part_no', 'like', '%' . $searchVal . '%');
                                //     });
                                // } else {
                                    $query->orWhere($column, 'like', '%' . $searchVal . '%');
                                // }
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
                $availableColors = ['#FF5733', '#46b259', '#3375FF', '#FF33A8', '#FFD733']; // Define different colors

                foreach ($resultArr as $row) {
                    $actionhtml = '';

                    preg_match('/ORD-(\d{2}-\d{2})-/', $row->order_code, $matches);
                    $financialYear = $matches[1] ?? 'Unknown';

                    // Assign the same color to all orders of the same financial year
                    if (!isset($financialYearColors[$financialYear])) {
                        $financialYearColors[$financialYear] = array_shift($availableColors) ?? '#1b84ff';
                    }

                    $orderColor = $financialYearColors[$financialYear];

                    $orderCodeBadge = '<span class="badge" style="background-color:' . $orderColor . '; color: #fff; padding: 5px 10px;">' . $row->order_code . '</span>';

                    $actionhtml .= '<div class="dropdown">';
                    $actionhtml .= '<a href="javascript:;" class="menu-link px-3" id="dropdownMenuButton' . $row["id"] . '"                 data-bs-toggle="dropdown" aria-expanded="false">';
                    $actionhtml .= '<i style="font-size:1.3rem;" class="icon-xl fas fa-cog" title="Actions"></i>';
                    $actionhtml .= '</a>';
                    $actionhtml .= '<ul class="dropdown-menu dropdown-menu-lg px-3" aria-labelledby="dropdownMenuButton' . $row["id"] . '">';

                    if ($user->hasRole('Customer')) {
                        $actionhtml .= '<li><a class="dropdown-item" href="' . route('view-accepted-order1', $row['id']) . '" ><i class="fa fa-eye text-info"></i> View</a></li>';
                    } else {
                        if ($user->can('accepted-order view')) {
                            $actionhtml .= '<li><a class="dropdown-item" href="' . route('view-accepted-order', $row['id']) . '" ><i class="fa fa-eye text-info"></i> View</a></li>';
                        }
                    }

                    $actionhtml .= '</ul>';
                    $actionhtml .= '</div>';

                    $sender_name = $row->sender_name ?? 'N/A';
                    $sender_email = $row->sender_email ?? 'N/A';
                    $sender_country_code = $row->sender_country_code ? '+' . $row->sender_country_code : '';
                    $sender_phone_no = $row->sender_phone_no ? $sender_country_code . ' ' . $row->sender_phone_no : 'N/A';

                    // $sender_location = $row->senderPortId->location ? '(' . $row->senderPortId->location.')' : '';
                    // $sender_Port= $row->senderPortId->port_name ? $row->senderPortId->port_name . ' ' . $sender_location : 'N/A';
                    $sender_Port = $row->senderPortId->port_name ? $row->senderPortId->port_name : 'N/A';

                    $receiver_name = $row->receiver_name ?? 'N/A';
                    $receiver_email = $row->receiver_email ?? 'N/A';
                    $receiver_country_code = $row->receiver_country_code ? '+' . $row->receiver_country_code : '';
                    $receiver_phone_no = $row->receiver_phone_no ? $receiver_country_code . ' ' . $row->receiver_phone_no : 'N/A';

                    // $receiver_location = $row->receiverPortId->location ? '(' . $row->receiverPortId->location.')' : '';
                    // $receiver_Port= $row->receiverPortId->port_name ? $row->receiverPortId->port_name . ' ' . $receiver_location : 'N/A';
                    $receiver_Port = $row->receiverPortId->port_name ? $row->receiverPortId->port_name : 'N/A';

                    $sender_details = '<div class="d-flex align-items-center">
                                        <div class="d-flex justify-content-start flex-column">
                                            <span class="text-gray-800 fw-bold text-hover-primary mb-1 fs-6">'
                        . $sender_name . '</span>
                                            <span class="text-primary">' . $sender_Port . '</span>
                                            <span class="text-gray-500 fw-semibold d-block fs-7">' . $sender_email . '
                                            </span>
                                            <span class="text-gray-500 fw-semibold d-block fs-7">' . $sender_phone_no . '
                                            </span>
                                        </div>
                                    </div>';

                    $receiver_details = '<div class="d-flex align-items-center">
                                        <div class="d-flex justify-content-start flex-column">
                                            <span class="text-gray-800 fw-bold text-hover-primary mb-1 fs-6">'
                        . $receiver_name . '</span>
                                            <span class="text-primary">' . $receiver_Port . '</span>
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

                    // $orderBadge = match ((int) $row->order_status) {
                    //     1 => '<span class="badge badge-outline badge-warning">Pending</span>',
                    //     2 => '<span class="badge badge-outline badge-primary">Accepted</span>',
                    //     3 => '<span class="badge badge-outline badge-danger">Rejected</span>',
                    //     4 => '<span class="badge badge-outline badge-info">Shipped</span>',
                    //     5 => '<span class="badge badge-outline badge-success">Delivery</span>',
                    //     default => '<span class="badge badge-outline badge-secondary">Unknown</span>',
                    // };

                    if ($user->hasRole('Customer')) {
                        $orderCodeBadge = ' <a href="' . route('view-accepted-order1', $row['id']) . '" class="">' . $orderCodeBadge . '</a>';
                    } else {
                        if ($user->can('accepted-order view')) {
                            $orderCodeBadge = ' <a href="' . route('view-accepted-order', $row['id']) . '" class="">' . $orderCodeBadge . '</a>';
                        } else {
                            $orderCodeBadge = $orderCodeBadge;
                        }
                    }

                    $i++;
                    $nestedData = array();
                    $nestedData[] = $i;
                    $nestedData[] = $orderCodeBadge;
                    $nestedData[] = $sender_details;
                    $nestedData[] = $receiver_details;
                    $nestedData[] = $row->final_total;
                    $nestedData[] = $paymentBadge;
                    // $nestedData[] = $orderBadge;
                    $nestedData[] = new_date_time_br_formate($row->created_at, 'd-m-Y H:i A');
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
        }
    }
}
