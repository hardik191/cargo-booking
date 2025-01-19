<?php

namespace App\Http\Controllers\backend\authentication;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ErrorController extends Controller
{
    public function accessDenied(){
        $data['title'] =  'Access Denied'.'||'.get_system_name();

        $user = Auth::user();
        if($user->hasRole('Customer')){
            $url = route('customer-dashboard');
        } else {
            $url = route('dashboard');
        }
        $data['route'] = $url;
        return view('error.access_denied', $data);
    }
}
