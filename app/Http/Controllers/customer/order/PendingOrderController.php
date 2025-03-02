<?php

namespace App\Http\Controllers\customer\order;

use App\Http\Controllers\Controller;
use App\Models\Container;
use App\Models\OrderCharge;
use App\Models\Port;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

class PendingOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
