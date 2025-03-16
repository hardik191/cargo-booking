<?php

namespace App\Http\Controllers\customer\order;

use App\Http\Controllers\Controller;
use App\Models\Container;
use App\Models\Order;
use App\Models\OrderCharge;
use App\Models\OrderChargeDetail;
use App\Models\OrderContainerDetail;
use App\Models\OrderHistory;
use App\Models\Payment;
use App\Models\Port;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use App\Notifications\CreateOrderNotification;
use Illuminate\Support\Facades\Notification;

class PendingOrderController extends Controller
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
            'validate/jquery.validate.min.js',
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

        if ($user->hasRole('Customer')) {
            $data['title'] =  'Pending Order List' . ' || ' . get_system_name();
            $data['header'] = array(
                'title' => 'Pending Order List',
                'breadcrumb' => array(
                    'Home' => route('dashboard1'),
                    'Create Order' => route('create-order'),
                    'Pending Order List' => 'Pending Order List',
                )
            );
            return view('customer.pages.order.pending_order.list', $data);
        } else {
            $data['title'] =  'Pending Order List' . ' || ' . get_system_name();
            $data['header'] = array(
                'title' => 'Pending Order List',
                'breadcrumb' => array(
                    'Home' => route('dashboard'),
                    'Pending Order List' => 'Pending Order List',
                )
            );

            if ($user->can('pending-order list')) {
                return view('customer.pages.order.pending_order.list', $data);
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
            'create_order.js',
        );
        $data['funinit'] = array(
            'Order.create()'
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
                // 'my_order_qty' => 'required|array',
                // 'my_order_qty.*' => 'required|numeric|min:0',
                // 'my_capacity' => 'required|array',
                // 'my_capacity.*' => 'required|numeric|min:0',
                // 'sub_price' => 'required|array',
                // 'sub_price.*' => 'required|numeric|min:0',
                // 'charge_type' => 'required|array',
                // 'charge_type.*' => 'required|integer|min:0|max:5',
                // 'charge_value' => 'required|array',
                // 'charge_value.*' => 'required|numeric|min:0',
            ]);

            // Create a new order
            $order = Order::create([
                'sender_name' => $request->sender_name,
                'sender_email' => $request->sender_email,
                'sender_phone_no' => $request->sender_phone_no,
                'sender_port_id' => $request->sender_port,
                'sender_country_code' => $request->sender_country_code ?? 91,
                'receiver_name' => $request->receiver_name,
                'receiver_email' => $request->receiver_email,
                'receiver_phone_no' => $request->receiver_phone_no,
                'receiver_country_code' => $request->receiver_country_code ?? 91,
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
            foreach ($request->container_id as $index => $container_id) {
                if ($container_id) {
                    $findContainer = Container::find($request->container_id[$index]);
                    OrderContainerDetail::create([
                        'order_id' => $order->id,
                        'container_id' => $request->container_id[$index],

                        'max_capacity' => $findContainer->max_capacity,
                        'capacity_unit' => $findContainer->capacity_unit,
                        'base_price' => $findContainer->base_price,

                        'my_order_qty' => $request->my_order_qty[$index] ?? 0,
                        'my_capacity' => $request->my_capacity[$index] ?? 0,
                        'sub_price' => $request->sub_price[$index] ?? 0,
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

            OrderHistory::create([
                'order_id' => $order->id,
                'description' => 'Your order is placed, please wait for the admin accepted',
                'order_status' => 1,
                'add_by' => Auth::id(),
                'updated_by' => Auth::id(),
            ]);

            OrderHistory::create([
                'order_id' => $order->id,
                'description' => 'Waiting for payment to be completed.',
                'order_status' => 6,
                'add_by' => Auth::id(),
                'updated_by' => Auth::id(),
            ]);

            $authUser = Auth::user();
            if ($authUser) {
                $authUser->notify(new CreateOrderNotification($order));
            }

            // **Step 2: Notify Users with "Notification Create Order" Permission**
            $usersWithPermission = User::permission('Notification Create Order')->get();
            Notification::send($usersWithPermission, new CreateOrderNotification($order));



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
    public function show($id)
    {
        $user = Auth::user();
        if ($user->hasRole('Customer')) {
            $data['order_details'] = Order::with(['orderContainerDetailMany', 'orderChargeDetailMany'])->where('add_by', $user->id)->where('id', $id)->first();

            $data['title'] =  'Pending Order View' . ' || ' . get_system_name();
            $data['header'] = array(
                'title' => 'Pending Order View',
                'breadcrumb' => array(
                    'Home' => route('dashboard1'),
                    'Pending Order' => route('pending-order1'),
                    'Pending Order View' => 'Pending Order View',
                )
            );
        } else {
            $data['order_details'] = Order::with(['orderContainerDetailMany', 'orderChargeDetailMany'])->where('id', $id)->first();

            $data['title'] =  'Pending Order View' . ' || ' . get_system_name();
            $data['header'] = array(
                'title' => 'Pending Order View',
                'breadcrumb' => array(
                    'Home' => route('dashboard'),
                    'Pending Order' => route('pending-order'),
                    'Pending Order View' => 'Pending Order View',
                )
            );
        }

        if (is_null($data['order_details'])) {
            if ($user->hasRole('Customer')) {
                return redirect()->route('pending-order1')->with('warning', 'Order not found.');
            } else {
                return redirect()->route('pending-order')->with('warning', 'Order not found.');
            }
        }

        $data['chargeTypes'] = Config::get('constants.CHARGE_TYPE'); // Get charge type names
        $data['paymentMode'] = Config::get('constants.PAYMENT_MODE'); // Get charge type names

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
        if ($user->hasRole('Customer')) {
            $data['funinit'] = array(
                'Pending_order.view()'
            );
            return view('customer.pages.order.pending_order.view', $data);
        } else {
            if ($user->can('pending-order view')) {

                $data['funinit'] = array(
                    'Pending_order.admin_view()'
                );
                return view('customer.pages.order.pending_order.admin_view', $data);
            } else {
                return redirect()->route('access-denied');
            }
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $user = Auth::user();

        $data['order_details'] = Order::with(['orderContainerDetailMany', 'orderChargeDetailMany'])
            ->where('order_status', '1')
            ->where('is_accepted_order', '1')
            ->where('add_by', $user->id)
            ->where('id', $id)
            ->first();


        if (is_null($data['order_details'])) {
            return redirect()->route('pending-order1')->with('warning', 'Order not found.');
        }

        $data['port_details'] = Port::where('status', '1')->orWhere('id', $data['order_details']->sender_port_id)->orWhere('id', $data['order_details']->receiver_port_id)->get();

        // $data['container_details'] = Container::where('status', '1')->get();
        // $data['order_charge_details'] = OrderCharge::where('status', '1')->get();

        $data['container_details'] = Container::where('status', '1')
            ->orWhereIn('id', OrderContainerDetail::where('order_id', $id)->pluck('container_id'))
            ->get();

        $data['order_charge_details'] = OrderCharge::where('status', '1')
            ->orWhereIn('id', OrderChargeDetail::where('order_id', $id)->pluck('charge_id'))
            ->get();

        $data['chargeTypes'] = Config::get('constants.CHARGE_TYPE'); // Get charge type names

        $data['title'] =  'Edit Order' . ' || ' . get_system_name();
        $data['header'] = array(
            'title' => 'Edit Order',
            'breadcrumb' => array(
                'Home' => route('dashboard1'),
                'Pending Order' => route('pending-order1'),
                'Edit Order' => 'Edit Order',
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
            'create_order.js',
        );
        $data['funinit'] = array(
            'Order.edit()'
        );

        return view('customer.pages.order.order.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        DB::beginTransaction();
        try {
            // Validate Request Data
            $request->validate([
                'sender_name' => 'required|string|max:255',
                'sender_email' => 'required|email|max:255',
                'sender_phone_no' => 'required|', // digits_between:8,15
                'sender_port' => 'required|exists:ports,id',
                'receiver_name' => 'required|string|max:255',
                'receiver_email' => 'required|email|max:255',
                'receiver_phone_no' => 'required|', //digits_between:8,15
                'receiver_port' => 'required|exists:ports,id',
                'total_qty' => 'required|numeric|min:1',
                'total_price' => 'required|numeric|min:0',
                'total_charge' => 'required|numeric|min:0',
                'final_total' => 'required|numeric|min:0',
                // 'my_order_qty' => 'required|array',
                // 'my_order_qty.*' => 'required|numeric|min:0',
                // 'my_capacity' => 'required|array',
                // 'my_capacity.*' => 'required|numeric|min:0',
                // 'sub_price' => 'required|array',
                // 'sub_price.*' => 'required|numeric|min:0',
                // 'charge_type' => 'required|array',
                // 'charge_type.*' => 'required|integer|min:0|max:5',
                // 'charge_value' => 'required|array',
                // 'charge_value.*' => 'required|numeric|min:0',
            ]);

            // Update Order
            $order = Order::findOrFail($request->editId);
            $order->update([
                'sender_name' => $request->sender_name,
                'sender_email' => $request->sender_email,
                'sender_phone_no' => $request->sender_phone_no,
                'sender_country_code' => $request->sender_country_code ?? 91,
                'sender_port_id' => $request->sender_port,
                'receiver_name' => $request->receiver_name,
                'receiver_email' => $request->receiver_email,
                'receiver_phone_no' => $request->receiver_phone_no,
                'receiver_country_code' => $request->receiver_country_code ?? 91,
                'receiver_port_id' => $request->receiver_port,
                'total_capacity' => array_sum($request->my_capacity),
                'total_qty' => $request->total_qty,
                'total_price' => $request->total_price,
                'total_charge' => $request->total_charge,
                'final_total' => $request->final_total,
                'order_status' => 1, // Pending
                'payment_status' => 1, // Pending
                'updated_by' => auth()->id(),
            ]);

            // Update Container Details
            foreach ($request->container_detail_main_id as $index => $container_detail_main_id) {
                if ($container_detail_main_id) {
                    $container_detail_main_id = $request->container_detail_main_id[$index] ?? null;

                    OrderContainerDetail::updateOrCreate(
                        ['id' => $container_detail_main_id], // Use ID if exists
                        [
                            'order_id' => $order->id,
                            'container_id' => $request->container_id[$index],

                            // 'max_capacity' => $request->max_capacity[$index],
                            // 'capacity_unit' => $request->capacity_unit[$index],
                            // 'base_price' => $request->base_price[$index],

                            'my_order_qty' => $request->my_order_qty[$index] ?? 0,
                            'my_capacity' => !empty($request->my_order_qty[$index]) && $request->my_order_qty[$index] > 0 ? ($request->my_capacity[$index] ?? 0) : 0,
                            'sub_price' => $request->sub_price[$index] ?? 0,
                            'updated_by' => auth()->id(),
                        ]
                    );
                }
            }

            // Update Order Charge Details
            foreach ($request->charge_type as $index => $chargeType) {
                OrderChargeDetail::updateOrCreate(
                    ['id' => $request->charge_detail_main_id[$index] ?? null], // Use ID if exists
                    [
                        'order_id' => $order->id,
                        'charge_id' => $request->charge_id[$index],
                        'charge_type' => $chargeType,
                        'charge_value' => $request->charge_value[$index],
                        'updated_by' => auth()->id(),
                    ]
                );
            }

            DB::commit();
            $return = [
                'status' => 'success',
                'message' => 'Order successfully updated.',
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

    public function order_status(Request $request)
    {
        DB::beginTransaction();
        try {
            // Validate Request Data
            $request->validate([
                'order_status' => ['required', 'integer'],
                'reason' => ['required_if:order_status,3'],
            ], [
                'order_status.required' => 'Please select an order status.',
                'order_status.integer' => 'Invalid order status selection.',
                'reason.required_if' => 'A reason is required when rejecting an order.',
            ]);


            $findOrder = Order::where('id', $request->editId)->first();

            $findOrder->update([
                'order_status' => $request->order_status,
                'updated_by' => Auth::id(),
            ]);

            $history_order_details = Config::get('constants.HISTORY_ORDER_STATUS');
            $orderStatusDetail = $history_order_details[$request->order_status];
            $order_status = $request->order_status;
            if ($request->order_status == 2) {
                OrderHistory::create([
                    'order_id' => $findOrder->id,
                    'description' => 'Your order has been accepted! It will be processed and dispatched soon.',
                    'order_status' => $order_status,
                    'add_by' => Auth::id(),
                    'updated_by' => Auth::id(),
                ]);
            } else {
                // OrderHistory::create([
                //     'order_id' => $findOrder->id,
                //     'description' => 'Your order has been cancelled.',
                //     'order_status' => $order_status,
                //     'add_by' => Auth::id(),
                //     'updated_by' => Auth::id(),
                // ]);

                OrderHistory::create([
                    'order_id' => $findOrder->id,
                    'description' => $request->reason,
                    'order_status' => $order_status,
                    'add_by' => Auth::id(),
                    'updated_by' => Auth::id(),
                ]);
            }

            DB::commit();
            $return = [
                'status' => 'success',
                'message' => 'Order successfully updated.',
                'jscode' => '$("#loader").hide();',
                'redirect' =>  route('pending-order'),
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

    public function order_payment_status(Request $request)
    {
        DB::beginTransaction();
        try {
            // Validate Request Data
            $request->validate([
                'payment_status' => ['required'],
                'payment_mode' => ['required'],
            ], [
                'payment_status.required' => 'Please select payment status.',
                'payment_mode.required' => 'Please select payment mode.',
            ]);


            $findOrder = Order::where('id', $request->editId)->first();

            $findOrder->update([
                'payment_status' => $request->payment_status,
                'updated_by' => Auth::id(),
            ]);

            // $history_order_details = Config::get('constants.HISTORY_ORDER_STATUS');
            // $orderStatusDetail = $history_order_details[$request->order_status];
            // $order_status = $request->order_status;

            Payment::create([
                'order_id' => $findOrder->id,
                'user_id' => Auth::id(),
                'order_amount' => $findOrder->final_total,
                'payment_document' => null,
                'payment_mode' => $request->payment_mode,
                'payment_status' => 2,
                'payment_date' => Carbon::now(),
                'add_by' => Auth::id(),
                'updated_by' => Auth::id(),
            ]);

            OrderHistory::create([
                'order_id' => $findOrder->id,
                'description' => 'Payment was received!',
                'order_status' => 7,
                'add_by' => Auth::id(),
                'updated_by' => Auth::id(),
            ]);

            DB::commit();
            $return = [
                'status' => 'success',
                'message' => 'Order successfully updated.',
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
                    $query = Order::where('is_deleted', '1')->where('order_status', '1')->where('add_by', $user->id);
                } else {
                    $query = Order::where('is_deleted', '1')->where('order_status', '1');
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
                        if ($row->order_status == 1 && $row->is_accepted_order == 1) {
                            $actionhtml .= '<li><a class="dropdown-item " href="' . route('edit-order',  $row["id"]) . '" data-id="' . $row["id"] . '"><i class="fa fa-edit text-warning"></i> Edit</a></li>';
                        }
                        $actionhtml .= '<li><a class="dropdown-item" href="' . route('view-pending-order1', $row['id']) . '" ><i class="fa fa-eye text-info"></i> View</a></li>';
                    } else {
                        if ($user->can('pending-order view')) {
                            $actionhtml .= '<li><a class="dropdown-item" href="' . route('view-pending-order', $row['id']) . '" ><i class="fa fa-eye text-info"></i> View</a></li>';
                        }

                        if ($user->can('pending-order Payment Alert')) {

                            if ($row->payment_status == 1) {
                                $actionhtml .= '<li><a class="dropdown-item change-payment-alert" href="javascript:;" data-bs-toggle="modal" data-bs-target="#orderPaymentModal" data-id="' . $row["id"] . '" data-payment-alert="2">
                                            <i class="ki-duotone ki-two-credit-cart fs-3 text-primary">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                                <span class="path3"></span>
                                                <span class="path4"></span>
                                                <span class="path5"></span>
                                            </i> Payment Alert</a></li>';
                            }
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
                        $orderCodeBadge = ' <a href="' . route('view-pending-order1', $row['id']) . '" class="">' . $orderCodeBadge . '</a>';
                    } else {
                        if ($user->can('pending-order view')) {
                            $orderCodeBadge = ' <a href="' . route('view-pending-order', $row['id']) . '" class="">' . $orderCodeBadge . '</a>';
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
                    $nestedData[] = new_date_time_br_formate($row->created_at);
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

            case 'common-change-order':
                $data = $request->input('data');

                $findId = Order::find($data['id']);
                $result = $findId->update([
                    'order_status' => $data['change_status'],
                    'updated_by' => $user->id,
                    'updated_at' => Carbon::now(),
                ]);

                $statusMessages = [
                    1 => 'Order successfully Pending.',
                    2 => 'Order successfully Accepted.',
                    3 => 'Order successfully Rejected.',
                    4 => 'Order successfully Shipped.',
                    5 => 'Order successfully Deliver.',
                ];

                $statusRedirects = [
                    1 => route('pending-order'),
                    2 => route('pending-order'),
                    3 => route('pending-order'),
                    4 => route('accepted-order'),
                    5 => route('shipped-order'),
                ];

                if ($data['change_status'] == 4) { // shipped
                    OrderHistory::create([
                        'order_id' => $data['id'],
                        'description' => 'Your order has been shipped and is on its way to you. You’ll receive a tracking update soon!',
                        'order_status' => 4,
                        'add_by' => Auth::id(),
                        'updated_by' => Auth::id(),
                    ]);
                } else if ($data['change_status'] == 5) {
                    OrderHistory::create([
                        'order_id' => $data['id'],
                        'description' => 'Your order has been delivered.',
                        'order_status' => 5,
                        'add_by' => Auth::id(),
                        'updated_by' => Auth::id(),
                    ]);
                }

                if (isset($result)) {
                    $return['status'] = 'success';
                    $return['message'] = $statusMessages[$data['change_status']];
                    $return['jscode'] = '$("#loader").hide();$("#orderModal").modal("hide");';
                    $return['redirect'] = $statusRedirects[$data['change_status']] ?? route('pending-order');
                } else {
                    $return['status'] = 'error';
                    $return['jscode'] = '$("#loader").hide();';
                    $return['message'] = 'Something went wrong.';
                }
                echo json_encode($return);
                exit;

            case 'order-payment-alert':
                $data = $request->input('data');

                $findId = Order::find($data['id']);

                if ($findId->is_accepted_order == 2) {
                    OrderHistory::create([
                        'order_id' => $data['id'],
                        'description' => 'Order confirmed after payment. Please remember to send the payment.',
                        'order_status' => 9,
                        'add_by' => Auth::id(),
                        'updated_by' => Auth::id(),
                    ]);
                } 
                    $result = $findId->update([
                        'is_accepted_order' => $data['payment_alert'],
                        'updated_by' => $user->id,
                        'updated_at' => Carbon::now(),
                    ]);
                



                $statusRedirects = [
                    2 => route('pending-order'),
                ];

                // if ($data['change_status'] == 4) { // shipped
                //     OrderHistory::create([
                //         'order_id' => $data['id'],
                //         'description' => 'Your order has been shipped and is on its way to you. You’ll receive a tracking update soon!',
                //         'order_status' => 4,
                //         'add_by' => Auth::id(),
                //         'updated_by' => Auth::id(),
                //     ]);
                // } 

                if (isset($result)) {
                    $return['status'] = 'success';
                    $return['message'] = 'Payment Alert Successfully.';
                    $return['jscode'] = '$("#loader").hide();$("#orderPaymentModal").modal("hide");';
                    $return['ajaxcall'] = 'Pending_order.init()';
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
