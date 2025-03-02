<?php

namespace App\Http\Controllers\customer\authentication;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class CustomerLoginController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function sign_in()
    {
        $data['title'] =  'Sign In' . ' || ' . get_system_name();
        $data['header'] = array(
            'title' => 'Sign In',
        );
        $data['css'] = array(
            'toastr/toastr.min.css'
        );
        $data['plugincss'] = array();
        $data['pluginjs'] = array(
            'toastr/toastr.min.js',
            'validate/jquery.validate.min.js',
        );
        $data['js'] = array(
            'comman_function.js',
            'jquery.form.min.js',
            'sign_up.js',
        );
        $data['funinit'] = array(
            'Sign_up.login()'
        );

        return view('customer.pages.authentication.sign_in.list', $data);
    }

    // login
    public function sign_in_login(Request $request)
    {
        $user = User::where(function ($query) use ($request) {
            $query->where('email', $request->login)
                ->orWhere('phone_no', $request->login);
        })
            ->whereHas('roles', function ($query) {
                $query->where('name', 'Customer'); // Filter only customers
            })
            ->first();

        if ($user) {
            if ($user->is_user_allowed_login == 2 && $user->password) {
                // if ($user && Auth::attempt(['email' => $request->input('email'), 'password' => $request->input('password')])) {
                if ($user && Auth::attempt(['id' => $user->id, 'password' => $request->input('password')])) {

                    $loginData = '';
                    $request->session()->forget('logindata');
                    $loginData = array(
                        // 'user_type' => Auth::user()->user_type,
                        'id' => Auth::user()->id
                    );
                    Session::push('logindata', $loginData);
                    $return['status'] = 'success';
                    $return['message'] = 'You have successfully logged in.';
                    $return['redirect'] = route('dashboard1');
                } else {
                    $return['status'] = 'error';
                    $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
                    $return['message'] = 'Invalid Login Id/Password';
                }
            } else {

                $return['sweet_alert'] = 'sweet_alert';
                $return['status'] = 'warning';
                $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
                $return['message'] = 'Your account does not have permission to log in. Please contact support for admin.';
            }
        } else {
            $return['sweet_alert'] = 'sweet_alert';
            $return['status'] = 'warning';
            $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
            $return['message'] = 'No account found. Please check your email or mobile number.';
        }
        return json_encode($return);
        exit();
    }

    public function sign_up()
    {
        $data['title'] =  'Sign Up' . ' || ' . get_system_name();
        $data['header'] = array(
            'title' => 'Sign Up',
        );
        $data['css'] = array(
            'toastr/toastr.min.css'
        );
        $data['plugincss'] = array();
        $data['pluginjs'] = array(
            'toastr/toastr.min.js',
            'validate/jquery.validate.min.js',
        );
        $data['js'] = array(
            'comman_function.js',
            'jquery.form.min.js',
            'sign_up.js',
        );
        $data['funinit'] = array(
            'Sign_up.add()'
        );

        return view('customer.pages.authentication.sign_up.list', $data);
    }

    // create acconut
    public function save_customer_account(Request $request)
    {
        DB::beginTransaction();
        try {
            $objUser = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'country_code' => $request->country_code,
                'phone_no' => $request->phone_no,
                'password' => Hash::make($request->input('password')),
            ]);

            $objUser->assignRole('Customer');

            UserDetail::create([
                'user_id' => $objUser->id,
                'user_code' => generateCustomerCode(),
                'add_by' => 1,
                'updated_by' => 1,
                // 'address' => $request->address,
            ]);

            DB::commit();
            $return = [
                'status' => 'success',
                'message' => 'Account created successfully',
                'jscode' => '$("#loader").hide();',
                'redirect' => route('sign-in'),
            ];
        } catch (\Exception $e) {
            DB::rollback();
            $return['status'] = 'error';
            $return['jscode'] = '$("#loader").hide();';
            $return['message'] = 'Something goes to wrong.';
            throw $e;
        }

        echo json_encode($return);
        exit;
    }

}
