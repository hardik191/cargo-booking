<?php

namespace App\Http\Controllers\backend\authentication;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class ForgotPasswordController extends Controller
{
    public function forgot_password_index(){
        $data['title'] =  'Forgot Password'.' || '.get_system_name();
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
            'forgot_password.js',
        );
        $data['funinit'] = array(
            'Forgot_password.init()'
        );
        $data['header'] = array(
            'title' => 'Forgot Password',
        );

        return view('backend.pages.authentication.forgot_password.list', $data);
    }

    public function mail_Sent(Request $request){
        DB::beginTransaction();
        try {
            $request->validate([
                'email' => 'required|email|exists:users,email',
            ], [
                'email.required' => 'Please enter your email address.',
                'email.email' => 'Please enter a valid email address.',
                'email.exists' => 'Your enter email address was not found.',
            ]);

            DB::table('password_reset_tokens')->where(['email'=> $request->email])->delete();
            $token = Str::random(64);

            // $result = PasswordReset::create([
            //     'email' => $request->email,
            //     'token' => $token,
            //     'created_at' => Carbon::now()
            // ]);

            $result = DB::table('password_reset_tokens')->insert([
                'email' => $request->email,
                'token' => $token,
                'created_at' => Carbon::now()
            ]);

            $user = User::Where('email', $request->email)->first();

            Mail::send('emails.forget_password', ['token' => $token, 'name' => $user->name], function($message) use($request){
                $message->to($request->email);
                $message->subject('Reset Password');
            });

            if(isset($result)){
                $return = [
                    'status' => 'success',
                    'message' => 'We have send a password reset link to your email.',
                    'jscode' => '$("#loader").hide();',
                    'redirect' => route('login'),
                ];
            } else {
                $return = [
                    'status' => 'error',
                    'jscode' => '$("#loader").hide();',
                    'message' => 'Something goes to wrong.',
                ];
            }
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

            $return = [
                'status' => 'error',
                'jscode' => '$("#loader").hide();',
                'message' => 'Something went wrong. Please try again.',
            ];
        }
        return json_encode($return);
            exit();
    }

    public function reset_password_index($token){

        $data['token'] =  $token;

        $token_check = DB::table('password_reset_tokens')
        ->where(['token' => $token])
        ->first();

        $data['title'] =  'Reset Password'.' || '.get_system_name();
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
            'forgot_password.js',
        );
        $data['funinit'] = array(
            'Forgot_password.reset()'
        );
        $data['header'] = array(
            'title' => 'Reset Password',
        );

        if (!isset($token_check) || is_null($token_check) || empty($token_check)) {
            return view('error.forgot_expired_link', $data);
        } else{
            return view('backend.pages.authentication.reset_password.list', $data);
        }
    }

    public function submit_reset_password(Request $request){
        $request->validate([
            'password' => 'required|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/', // Custom regex for password validation
            'confirm_password' => 'required|same:password',
        ]);
// dd($request->all());
        try {
            DB::beginTransaction();

            // Check if the token is valid
            $updatePassword = DB::table('password_reset_tokens')
            ->where('token', $request->token)
            ->first();

            if (!$updatePassword) {
                $return = [
                    'status' => 'warning',
                    'jscode' => '$("#loader").hide();',
                    'message' => 'Please enter a valid email address.',
                ];
            } else {
                // Update the user's password

                $user = User::where('email', $updatePassword->email)->first();

                // Update the user's password
                $user->update(['password' => Hash::make($request->password)]);

                    // Mail::send('emails.change_password', [
                    //     'name' => $user->name,
                    //     'email' => $user->email,
                    //     'password' => $request->password
                    // ], function($message) use($user) {
                    //     $message->to($user->email);
                    //     $message->subject('New Login Credential');
                    // });

                // Delete the password reset token
                DB::table('password_reset_tokens')->where(['email'=> $updatePassword->email])->delete();
                DB::commit();
                $return = [
                    'status' => 'success',
                    'message' => 'Password has been successfully updated.',
                    'jscode' => '$("#loader").hide();',
                    'redirect' => route('login'),
                ];
            }
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
            DB::rollback();
            $return = [
                'status' => 'error',
                'jscode' => '$("#loader").hide();',
                'message' => 'Something goes to wrong.',
            ];
        }

        return json_encode($return);
        exit();
    }
}
