<?php

use App\Http\Controllers\backend\audit\AuditController;
use App\Http\Controllers\backend\authentication\ForgotPasswordController;
use App\Http\Controllers\backend\authentication\LoginController;
use App\Http\Controllers\backend\dashboard\DashboardController;
use App\Http\Controllers\backend\system_setting\SystemSettingController;
use App\Http\Controllers\roles_and_permissions\PermissionController;
use App\Http\Controllers\roles_and_permissions\RoleController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

$adminPrefix = "admin";
Route::group(['prefix' => $adminPrefix, 'middleware' => ['auth']], function () {

    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    //Audit
    Route::get('audit', [AuditController::class, 'index'])->name('audit');
    Route::post('audit-ajaxcall', [AuditController::class, 'ajaxcall'])->name('audit-ajaxcall');

    $adminPrefixs = "role-management";
    Route::group(['prefix' => $adminPrefixs, 'middleware' => ['auth']], function() {
        // Roles
        Route::get('roles', [RoleController::class, 'index'])->name('roles');
        Route::post('add-save-role', [RoleController::class, 'store'])->name('add-save-role');
        Route::post('edit-save-role', [RoleController::class, 'update'])->name('edit-save-role');
        Route::post('delete-role', [RoleController::class, 'destroy'])->name('delete-role');
        Route::post('role-ajaxcall', [RoleController::class, 'ajaxcall'])->name('role-ajaxcall');

        // Permissions
        Route::get('permissions', [PermissionController::class, 'index'])->name('permissions');
        Route::post('add-save-permission', [PermissionController::class, 'store'])->name('add-save-permission');
        Route::post('edit-save-permission', [PermissionController::class, 'update'])->name('edit-save-permission');
        Route::post('delete-permission', [PermissionController::class, 'destroy'])->name('delete-permission');
        Route::post('permission-ajaxcall', [PermissionController::class, 'ajaxcall'])->name('permission-ajaxcall');
    });

    //Update Profile
    Route::get('update-profile', [SystemSettingController::class, 'user_profile'])->name('update-profile');
    Route::post('update-save-profile', [SystemSettingController::class, 'update_save_profile'])->name('update-save-profile');

    //System Setting
    Route::get('system-setting', [SystemSettingController::class, 'index'])->name('system-setting');
    Route::post('save-system-setting', [SystemSettingController::class, 'store'])->name('save-system-setting');

});

Route::get('/superadmin', [LoginController::class, 'index'])->name('login');
Route::post('check-login', [LoginController::class, 'store'])->name('check-login');
Route::get('forgot-password', [ForgotPasswordController::class, 'forgot_password_index'])->name('forgot-password');
Route::post('forgot-password-mail-sent', [ForgotPasswordController::class, 'mail_Sent'])->name('forgot-password-mail-sent');
Route::get('reset-password/{token}', [ForgotPasswordController::class, 'reset_password_index'])->name('reset-password');
Route::post('submit-reset-password', [ForgotPasswordController::class, 'submit_reset_password'])->name('submit-reset-password');
Route::get('logout', [LoginController::class, 'logout'])->name('logout');

