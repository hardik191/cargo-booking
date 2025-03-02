<?php

namespace App\Http\Controllers\backend\authentication;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

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
        $user = User::where(function ($query) use ($request) {
            $query->where('email', $request->email);
                // ->orWhere('phone_no', $request->login);
        })
            ->whereHas('roles', function ($query) {
                $query->where('name', '!=', 'Customer'); // Filter only customers
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
                    $return['redirect'] = route('dashboard');
                } else {
                    $return['status'] = 'warning';
                    $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
                    $return['message'] = 'Invalid Login Id/Password';
                }
            } else {

                if ($user->id == 1) {
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
                        $return['redirect'] = route('dashboard');
                    } else {
                        $return['status'] = 'warning';
                        $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
                        $return['message'] = 'Invalid Login Id/Password';
                    }
                } else {
                    $return['sweet_alert'] = 'sweet_alert';
                    $return['status'] = 'warning';
                    $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
                    $return['message'] = 'Your account does not have permission to log in. Please contact support for admin.';
                }
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
        $userRole = Auth::user()->getRoleNames();
        // dd($userRole[0]);
        $request->session()->forget('logindata');
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();
        if ($userRole[0] == "Customer") {
            return redirect()->route('sign-in');
        } else {
            return redirect()->route('login');
        }
    }
}
