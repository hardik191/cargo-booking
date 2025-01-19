<?php

use App\Http\Controllers\backend\audit\AuditController;
use App\Http\Controllers\backend\authentication\ErrorController;
use App\Http\Controllers\backend\authentication\ForgotPasswordController;
use App\Http\Controllers\backend\authentication\LoginController;
use App\Http\Controllers\backend\dashboard\DashboardController;
use App\Http\Controllers\backend\system_setting\SystemSettingController;
use App\Http\Controllers\backend\user_management\AdminController;
use App\Http\Controllers\backend\user_management\CustomerController;
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

    $adminPrefixs = "user-management";
    Route::group(['prefix' => $adminPrefixs, 'middleware' => ['auth']], function() {

        // Customers
        Route::get('customer-list', [CustomerController::class, 'index'])->name('customer-list')->middleware('checkPermission:customer list');
        Route::get('view-customer/{id}',[CustomerController::class,'show'])->name('view-customer')->middleware('checkPermission:customer view');
        Route::post('customer-ajaxcall', [CustomerController::class, 'ajaxcall'])->name('customer-ajaxcall');

        // Admin
        Route::get('admin-list', [AdminController::class, 'index'])->name('admin-list')->middleware('checkPermission:admin list');
        Route::get('add-admin', [AdminController::class, 'create'])->name('add-admin')->middleware('checkPermission:admin add');
        Route::post('add-save-admin', [AdminController::class, 'store'])->name('add-save-admin');
        Route::get('edit-admin/{id}', [AdminController::class, 'edit'])->name('edit-admin')->middleware('checkPermission:admin edit');
        Route::post('edit-save-admin', [AdminController::class, 'update'])->name('edit-save-admin');
        Route::get('view-admin/{id}',[AdminController::class,'show'])->name('view-admin')->middleware('checkPermission:admin view');
        Route::post('admin-ajaxcall', [AdminController::class, 'ajaxcall'])->name('admin-ajaxcall');
    });

    //Update Profile
    Route::get('update-profile', [SystemSettingController::class, 'user_profile'])->name('update-profile');
    Route::post('update-save-profile', [SystemSettingController::class, 'update_save_profile'])->name('update-save-profile');

    //System Setting
    Route::get('system-setting', [SystemSettingController::class, 'index'])->name('system-setting');
    Route::post('save-system-setting', [SystemSettingController::class, 'store'])->name('save-system-setting');

});

Route::get('access-denied', [ErrorController::class, 'accessDenied'])->name('access-denied');

Route::get('/superadmin', [LoginController::class, 'index'])->name('login');
Route::post('check-login', [LoginController::class, 'store'])->name('check-login');
Route::get('forgot-password', [ForgotPasswordController::class, 'forgot_password_index'])->name('forgot-password');
Route::post('forgot-password-mail-sent', [ForgotPasswordController::class, 'mail_Sent'])->name('forgot-password-mail-sent');
Route::get('reset-password/{token}', [ForgotPasswordController::class, 'reset_password_index'])->name('reset-password');
Route::post('submit-reset-password', [ForgotPasswordController::class, 'submit_reset_password'])->name('submit-reset-password');
Route::get('logout', [LoginController::class, 'logout'])->name('logout');

