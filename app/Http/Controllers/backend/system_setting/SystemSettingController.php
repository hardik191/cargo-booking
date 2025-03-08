<?php

namespace App\Http\Controllers\backend\system_setting;

use App\Http\Controllers\Controller;
use App\Models\SystemSetting;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Config;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

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

    public function update_save_profile(Request $request)
    {
        // Validate request
        $request->validate([
            'editId' => 'required|exists:users,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $request->editId,
            'user_image' => 'nullable|image|mimes:jpeg,png,jpg',
        ]);

        DB::beginTransaction();

        try {
            // Find user
            $objUser = User::findOrFail($request->editId);

            // Prepare update data
            $data = [
                'name' => $request->name,
                'email' => $request->email,
            ];

            // Handle Image Upload

            if ($request->hasFile('user_image')) {
                // Delete old image if it exists
                if ($objUser->user_image) {
                    $oldImagePath = 'uploads/userprofile/' . $objUser->user_image;
                    if (Storage::exists('public/' . $oldImagePath)) {
                        Storage::delete('public/' . $oldImagePath);
                    }
                }
                // Upload new image
                $data['user_image'] = $this->uploadUserImage($request->file('user_image'), $objUser->user_image);
            } elseif ($request->avatar_remove == 1) {
                // Remove the image
                if ($objUser->user_image) {
                    $oldImagePath = 'uploads/userprofile/' . $objUser->user_image;
                    if (Storage::exists('public/' . $oldImagePath)) {
                        Storage::delete('public/' . $oldImagePath);
                    }
                }
                $data['user_image'] = null;
            }

            // Update user data
            $objUser->updateOrFail($data);

            DB::commit(); // Commit transaction

            $return = [
                'status' => 'success',
                'message' => 'Your profile successfully updated.',
                'jscode' => '$(".submitbtn:visible").removeAttr("disabled").attr("data-kt-indicator", "off");$("#loader").hide();',
                'redirect' => route('update-profile'),

                // 'ajaxcall' => 'Order_charge.init()'
            ];
            echo json_encode($return);
            exit;
        } catch (ValidationException $e) {
            DB::rollBack();

            $errorMessages = '<ul>';
            foreach ($e->errors() as $error) {
                $errorMessages .= '<li class="text-start">' . implode('</li><li>', $error) . '</li>';
            }
            $errorMessages .= '</ul>';

            $return = [
                'sweet_alert' => 'sweet_alert',
                'status' => 'warning',
                'message' => $errorMessages, // Show all errors
                'jscode' => '$(".submitbtn:visible").removeAttr("disabled").attr("data-kt-indicator", "off");$("#loader").hide();',
            ];
            echo json_encode($return);
            exit;
        } catch (\Exception $e) {
            DB::rollBack();

            $return = [
                'status' => 'warning',
                'jscode' => '$("#loader").hide();',
                'message' => 'Something goes to wrong.',
            ];
            echo json_encode($return);
            exit;
        }

       
    }

    private function uploadUserImage($image, $oldImage = null)
    {
        // Delete the old image if it exists
        if ($oldImage) {
            $oldImagePath = 'public/uploads/userprofile/' . $oldImage;
            if (Storage::exists($oldImagePath)) {
                Storage::delete($oldImagePath);
            }
        }

        // Generate unique image name
        $imagename = 'user_image_' . time() . '.' . $image->getClientOriginalExtension();

        // Store image in the 'public/uploads/userprofile/' directory
        $image->storeAs('public/uploads/userprofile', $imagename);

        // Return new image name
        return $imagename;
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
                $return['status'] = 'warning';
                $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
                $return['message'] = 'Something goes to wrong';
            }
            echo json_encode($return);
            exit;

    }

    public function change_password()
    {
        $data['title'] =  'Change Password' . ' || ' . get_system_name();
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
            'update_profile.js',
        );
        $data['funinit'] = array(
            'Update_profile.change_password()'
        );
        $data['header'] = array(
            'title' => 'Change Password',
            'breadcrumb' => array(
                'Dashboard' => route('dashboard'),
                'Change Password' => 'Change Password',
            )
        );

        return view('backend.pages.system_setting.change_password', $data);
    }

    public function change_save_password(Request $request)
    {
        DB::beginTransaction();

        try {
            if(Auth::id() == $request->user_id){
                $findUser = User::find(Auth::id());

                if (!Hash::check($request->old_password, $findUser->password)) {
                    $return['sweet_alert'] = 'sweet_alert';
                    $return['status'] = 'warning';
                    $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
                    $return['message'] = 'Old password is incorrect.';

                    echo json_encode($return);
                    exit;
                }

                $objUser = $findUser->update([
                    'password' => Hash::make($request->new_password),
                ]);

                DB::commit();
                $return = [
                    'status' => 'success',
                    'message' => 'Password successfully updated.',
                    'jscode' => '$("#loader").hide();',
                    'redirect' => route('change-password'),
                ];
            }
        } catch (\Exception $e) {
            DB::rollback();
            $return['status'] = 'warning';
            $return['jscode'] = '$("#loader").hide();';
            $return['message'] = 'Something goes to wrong.';
            throw $e;
        }
        echo json_encode($return);
        exit;
    }
}
