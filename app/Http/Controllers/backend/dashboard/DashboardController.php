<?php

namespace App\Http\Controllers\backend\dashboard;

use App\Http\Controllers\Controller;
use App\Models\Container;
use App\Models\OrderCharge;
use App\Models\Port;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Spatie\Permission\Models\Role;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();

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
            'dashboard.js',
        );
        $data['funinit'] = array(
            'Dashboard.init()'
        );

        $data['port_details'] = Port::where('status', '1')->get();
        $data['container_details'] = Container::where('status', '1')->get();
        $data['order_charge_details'] = OrderCharge::where('status', '1')->get();

        $data['chargeTypes'] = Config::get('constants.CHARGE_TYPE'); // Get charge type names

        $data['total_role'] = Role::count();

        $data['total_customer'] = User::with('roles')
            ->where('status', '!=', '3')
            ->whereHas('roles', function ($query) {
                $query->where('name', 'Customer');
            })->count();

        $data['total_admin'] = User::with('roles')
            ->where('status', '!=', '3')
            ->whereHas('roles', function ($query) {
                $query->where('name', '!=', 'Customer');
            })->count();

        $data['total_port'] = Port::where('status', '!=', '3')->count();

        $data['total_container'] = Container::where('status', '!=', '3')->count();
        $data['total_order_charge'] = OrderCharge::where('status', '!=', '3')->count();
        
        if ($user->hasRole('Customer')) {
            $data['title'] =  'Dashboard' . ' || ' . get_system_name();
            $data['header'] = array(
                'title' => 'Dashboard',
                'breadcrumb' => array(
                    'Home' => route('dashboard1'),
                )
            );
            return view('backend.pages.dashboard.list', $data);
        } else {
            $data['title'] =  'Dashboard' . ' || ' . get_system_name();
            $data['header'] = array(
                'title' => 'Dashboard',
                'breadcrumb' => array(
                    'Home' => route('dashboard'),
                )
            );
            return view('backend.pages.dashboard.admin_list', $data);
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
