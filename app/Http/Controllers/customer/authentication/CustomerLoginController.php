<?php

namespace App\Http\Controllers\customer\authentication;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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
            'login.js',
        );
        $data['funinit'] = array(
            'Login.init()'
        );

        return view('customer.pages.authentication.sign_in.list', $data);
    }

    public function create()
    {
        //
    }

    // login
    public function sign_in_login(Request $request)
    {
        //
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
            'Sign_up.init()'
        );

        return view('customer.pages.authentication.sign_up.list', $data);
    }

    // create acconut
    public function save_customer_account(Request $request)
    {
        //
    }
}
