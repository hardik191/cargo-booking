<?php

namespace App\Http\Controllers\backend\system_setting;

use App\Http\Controllers\Controller;
use App\Models\SystemSetting;
use App\Models\User;
use App\Models\Users;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Config;

class SystemSettingController extends Controller
{

    public function user_profile()
    {
        $data['title'] =  'Update Profile'.' || '.get_system_name();
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
            'update_profile.js',
        );
        $data['funinit'] = array(
            'Update_profile.init()'
        );
        $data['header'] = array(
            'title' => 'Update Profile',
            'breadcrumb' => array(
                'Dashboard' => route('dashboard'),
                'Update Profile' => 'Update Profile',
            )
        );

        return view('backend.pages.system_setting.user_profile', $data);
    }

    public function update_save_profile(Request $request){

        // echo "<pre>"; print_r($request->editId); die();
        $status = '';

        $countUser = Users::where("email",$request->email)
                        ->where("id",'!=',$request->editId)
                        ->count();

        if($countUser == 0){

            $objUsers = Users::find($request->editId);
            $objUsers->name = $request->name;
            $objUsers->email = $request->email;
            if($request->user_image){
                $image = $request->user_image;
                $imagename = 'user_image'.time().'.'.$image->getClientOriginalExtension();
                $destinationPath = public_path('backend/upload/userprofile/');
                $image->move($destinationPath, $imagename);
                $objUsers->user_image  = $imagename ;
            }
            if($objUsers->save()){
                $status = 'true';
            }else{
                $status = false;
            }

        }else{
            $status = "email_exist";
        }


        if ($status == "true") {
            $return['status'] = 'success';
             $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
            $return['message'] = 'Your profile successfully updated.';
            $return['redirect'] = route('update-profile');
        } else {
            if ($status == "email_exist") {
                $return['status'] = 'error';
                 $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
                $return['message'] = 'The email address has already been registered.';
            }else{
                $return['status'] = 'error';
                 $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
                $return['message'] = 'Something goes to wrong';
            }
        }
        echo json_encode($return);
        exit;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['title'] =  'System Setting'.' || '.get_system_name();
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
            'system_setting.js',
        );
        $data['funinit'] = array(
            'System_setting.init()'
        );
        $data['header'] = array(
            'title' => 'System Setting',
            'breadcrumb' => array(
                'Dashboard' => route('dashboard'),
                'System Setting' => 'System Setting',
            )
        );

        return view('backend.pages.system_setting.system_setting', $data);
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


            $status = '';
            if($request->key == 'general_setting'){
                $validatedData = $request->validate([
                    'system_name' => 'required',
                    'footer_text' => 'required',
                    'sidebar_navbar_name' => 'required',
                    // 'header_navbar_name' => 'required',
                ], [
                    'system_name.required' => 'Please enter system name.',
                    'footer_text.required' => 'Please enter footer text',
                    'sidebar_navbar_name.required' => 'Please enter sidebar navbar name',
                    // 'header_navbar_name.required' => 'Please enter header navbar name',
                ]);
            }elseif($request->key == 'branding'){
                $objsystemsetting_details = SystemSetting::where('key', $request->key)->first();
                $image_details =  json_decode($objsystemsetting_details['value']);

                if ($request->hasFile('favicon_icon')) {
                    $image = $request->favicon_icon;
                    $imagename = 'favicon_icon'.time().'.'.$image->getClientOriginalExtension();
                    $destinationPath = public_path('backend/upload/system_setting/');
                    $image->move($destinationPath, $imagename);
                    $request['favicon_icon_name']  = $imagename ;
                }else{
                    $request['favicon_icon_name']  = isset($image_details->favicon_icon_name) ? $image_details->favicon_icon_name : '' ;

                }

                if ($request->hasFile('login_icon')) {
                    $image = $request->login_icon;
                    $imagename = 'login_icon'.time().'.'.$image->getClientOriginalExtension();
                    $destinationPath = public_path('backend/upload/system_setting/');
                    $image->move($destinationPath, $imagename);
                    $request['login_icon_name']  = $imagename ;
                }else{
                    $request['login_icon_name']  = isset($image_details->login_icon_name) ? $image_details->login_icon_name : '' ;

                }
            }
            elseif($request->key == 'email_setting'){
                $validatedData = $request->validate([
                    'server_name' => 'required',
                    'user_name' => 'required',
                    'password' => 'required',
                    'port' => 'required',
                    'driver' => 'required',
                    'encryption' => 'required',
                ], [
                    'server_name.required' => 'Please enter server (host) name.',
                    'user_name.required' => 'Please enter user name',
                    'password.required' => 'Please enter password',
                    'port.required' => 'Please enter port',
                    'driver.required' => 'Please enter driver',
                    'encryption.required' => 'Please select encryption',
                ]);
            }


            $json_data = json_encode($request->all());

            // ccd($json_data);


          $objsystemsetting = SystemSetting::where('key', $request->key)->update(['value'=> $json_data, 'updated_at' => Carbon::now()->format('Y-m-d h:i:s')]);
          $status = 'true';

            if ($status == "true") {
                $return['status'] = 'success';
                $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
                $return['message'] = 'System setting successfully updated.';
                $return['redirect'] = route('system-setting');
            } else {
                $return['status'] = 'error';
                $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
                $return['message'] = 'Something goes to wrong';
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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
