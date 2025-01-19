<?php

namespace App\Http\Controllers\backend\authentication;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;

class LoginController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['title'] =  'Login'.'||'.get_system_name();
        $data['css'] = array(
            'toastr/toastr.min.css'
        );
        $data['plugincss'] = array(
        );
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
        $data['header'] = array(
            'title' => 'Login',
        );

        return view('backend.pages.authentication.login.new_login', $data);

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


            if (Auth::attempt(['email' => $request->input('email'), 'password' => $request->input('password')])) {
                $loginData = '';
                $request->session()->forget('logindata');
                $loginData = array(
                    'user_type' => Auth::user()->user_type,
                    'id' => Auth::user()->id
                );
                Session::push('logindata', $loginData);
                $return['status'] = 'success';
                $return['message'] = 'You have successfully logged in.';
                $return['redirect'] = route('dashboard');
            } else {
                    $return['status'] = 'error';
                    $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
                    $return['message'] = 'Invalid Login Id/Password';
            }
            return json_encode($return);
            exit();

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

    public function logout(Request $request) {
        // $this->resetGuard();
        $userRole = Auth::user()->getRoleNames();
        // dd($userRole[0]);
        $request->session()->forget('logindata');
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

            return redirect()->route('login');
    }
}
