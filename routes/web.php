<?php

use App\Http\Controllers\backend\audit\AuditController;
use App\Http\Controllers\backend\authentication\ErrorController;
use App\Http\Controllers\backend\authentication\ForgotPasswordController;
use App\Http\Controllers\backend\authentication\LoginController;
use App\Http\Controllers\backend\container\ContainerController;
use App\Http\Controllers\backend\dashboard\DashboardController;
use App\Http\Controllers\backend\order_charge\OrderChargeController;
use App\Http\Controllers\backend\port\PortController;
use App\Http\Controllers\backend\system_setting\SystemSettingController;
use App\Http\Controllers\backend\user_management\AdminController;
use App\Http\Controllers\backend\user_management\CustomerController;
use App\Http\Controllers\CommonController;
use App\Http\Controllers\customer\authentication\CustomerLoginController;
use App\Http\Controllers\customer\order\AcceptedOrderController;
use App\Http\Controllers\customer\order\DeliveryOrderController;
use App\Http\Controllers\customer\order\PendingOrderController;
use App\Http\Controllers\customer\order\RejectedOrderController;
use App\Http\Controllers\customer\order\ShippedOrderController;
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

    Route::get('change-password', [SystemSettingController::class, 'change_password'])->name('change-password');
    Route::post('change-save-password', [SystemSettingController::class, 'change_save_password'])->name('change-save-password');

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
        // Route::get('view-admin/{id}',[AdminController::class,'show'])->name('view-admin')->middleware('checkPermission:admin view');
        Route::post('admin-ajaxcall', [AdminController::class, 'ajaxcall'])->name('admin-ajaxcall');
    });

    $adminPrefixs = "master-management";
    Route::group(['prefix' => $adminPrefixs, 'middleware' => ['auth']], function () {

        // Prot
        Route::get('port-list', [PortController::class, 'index'])->name('port-list')->middleware('checkPermission:port list');
        Route::post('add-save-port', [PortController::class, 'store'])->name('add-save-port');
        Route::post('edit-save-port', [PortController::class, 'update'])->name('edit-save-port');
        Route::post('port-ajaxcall', [PortController::class, 'ajaxcall'])->name('port-ajaxcall');

        // Containers
        Route::get('container-list', [ContainerController::class, 'index'])->name('container-list')->middleware('checkPermission:container list');
        Route::post('add-save-container', [ContainerController::class, 'store'])->name('add-save-container');
        Route::post('edit-save-container', [ContainerController::class, 'update'])->name('edit-save-container');
        Route::post('container-ajaxcall', [ContainerController::class, 'ajaxcall'])->name('container-ajaxcall');

        // charge
        Route::get('order-charge-list', [OrderChargeController::class, 'index'])->name('order-charge-list')->middleware('checkPermission:order-charge list');
        Route::post('add-save-order-charge', [OrderChargeController::class, 'store'])->name('add-save-order-charge');
        Route::post('edit-save-order-charge', [OrderChargeController::class, 'update'])->name('edit-save-order-charge');
        Route::post('order-charge-ajaxcall', [OrderChargeController::class, 'ajaxcall'])->name('order-charge-ajaxcall');
    });

    $adminPrefixs = "order-management";
    Route::group(['prefix' => $adminPrefixs, 'middleware' => ['auth']], function () {

        // Pending Application
        Route::get('pending-order', [PendingOrderController::class, 'index'])->name('pending-order');
        Route::get('view-pending-order/{id}', [PendingOrderController::class, 'show'])->name('view-pending-order');

        Route::post('edit-save-order-status', [PendingOrderController::class, 'order_status'])->name('edit-save-order-status');

        // Accepted order
        Route::get('accepted-order', [AcceptedOrderController::class, 'index'])->name('accepted-order');
        Route::get('view-accepted-order/{id}', [AcceptedOrderController::class, 'show'])->name('view-accepted-order');

        // Shipped order
        Route::get('shipped-order', [ShippedOrderController::class, 'index'])->name('shipped-order');
        Route::get('view-shipped-order/{id}', [ShippedOrderController::class, 'show'])->name('view-shipped-order');

        // Delivery order
        Route::get('delivery-order', [DeliveryOrderController::class, 'index'])->name('delivery-order');
        Route::get('view-delivery-order/{id}', [DeliveryOrderController::class, 'show'])->name('view-delivery-order');

        // Rejected Order
        Route::get('rejected-order', [RejectedOrderController::class, 'index'])->name('rejected-order');
        Route::get('view-rejected-order/{id}', [RejectedOrderController::class, 'show'])->name('view-rejected-order');
    });

    //Update Profile
    Route::get('update-profile', [SystemSettingController::class, 'user_profile'])->name('update-profile');
    Route::post('update-save-profile', [SystemSettingController::class, 'update_save_profile'])->name('update-save-profile');

    //System Setting
    Route::get('system-setting', [SystemSettingController::class, 'index'])->name('system-setting');
    Route::post('save-system-setting', [SystemSettingController::class, 'store'])->name('save-system-setting');

});

Route::get('access-denied', [ErrorController::class, 'accessDenied'])->name('access-denied');

Route::post('read-notification', [CommonController::class, 'ajaxcall'])->name('read-notification');

Route::get('/superadmin', [LoginController::class, 'index'])->name('login');
Route::post('check-login', [LoginController::class, 'store'])->name('check-login');
Route::get('logout', [LoginController::class, 'logout'])->name('logout');

// forgot
Route::get('forgot-password', [ForgotPasswordController::class, 'forgot_password_index'])->name('forgot-password');
Route::post('forgot-password-mail-sent', [ForgotPasswordController::class, 'mail_Sent'])->name('forgot-password-mail-sent');
Route::get('reset-password/{token}', [ForgotPasswordController::class, 'reset_password_index'])->name('reset-password');
Route::post('submit-reset-password', [ForgotPasswordController::class, 'submit_reset_password'])->name('submit-reset-password');

// Customer Login
Route::get('/', [CustomerLoginController::class, 'sign_in'])->name('sign-in');
Route::post('sign-in-check-login', [CustomerLoginController::class, 'sign_in_login'])->name('sign-in-check-login');

Route::get('/sign-up', [CustomerLoginController::class, 'sign_up'])->name('sign-up');
Route::post('save-create-customer-account', [CustomerLoginController::class, 'save_customer_account'])->name('save-create-customer-account');


// customer
$adminPrefix = "customer";
Route::group(['prefix' => $adminPrefix, 'middleware' => ['auth']], function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard1');

    // change password
    Route::get('change-password', [SystemSettingController::class, 'change_password'])->name('change-password1');

    $adminPrefixs = "order-management";
    Route::group(['prefix' => $adminPrefixs, 'middleware' => ['auth']], function () {

        Route::get('create-order', [PendingOrderController::class, 'create'])->name('create-order');
        Route::post('create-save-order', [PendingOrderController::class, 'store'])->name('create-save-order');
        Route::get('edit-order/{id}', [PendingOrderController::class, 'edit'])->name('edit-order');
        Route::post('update-save-order', [PendingOrderController::class, 'update'])->name('update-save-order');

        // Pending Application 1
        Route::get('pending-order', [PendingOrderController::class, 'index'])->name('pending-order1');
        Route::get('view-pending-order/{id}', [PendingOrderController::class, 'show'])->name('view-pending-order1');
        Route::post('pending-order-ajaxcall', [PendingOrderController::class, 'ajaxcall'])->name('pending-order-ajaxcall1');

        Route::post('edit-save-order-payment-satus', [PendingOrderController::class, 'order_payment_status'])->name('edit-save-order-payment-satus');

        // Accepted order 2
        Route::get('accepted-order', [AcceptedOrderController::class, 'index'])->name('accepted-order1');
        Route::get('view-accepted-order/{id}', [AcceptedOrderController::class, 'show'])->name('view-accepted-order1');
        Route::post('accepted-order-ajaxcall', [AcceptedOrderController::class, 'ajaxcall'])->name('accepted-order-ajaxcall1');

        // Shipped order 4
        Route::get('shipped-order', [ShippedOrderController::class, 'index'])->name('shipped-order1');
        Route::get('view-shipped-order/{id}', [ShippedOrderController::class, 'show'])->name('view-shipped-order1');
        Route::post('shipped-order-ajaxcall', [ShippedOrderController::class, 'ajaxcall'])->name('shipped-order-ajaxcall1');

        // Delivery order 5
        Route::get('delivery-order', [DeliveryOrderController::class, 'index'])->name('delivery-order1');
        Route::get('view-delivery-order/{id}', [DeliveryOrderController::class, 'show'])->name('view-delivery-order1');
        Route::post('delivery-order-ajaxcall', [DeliveryOrderController::class, 'ajaxcall'])->name('delivery-order-ajaxcall1');

        // Rejected Order 3
        Route::get('rejected-order', [RejectedOrderController::class, 'index'])->name('rejected-order1');
        Route::get('view-rejected-order/{id}', [RejectedOrderController::class, 'show'])->name('view-rejected-order1');
        Route::post('rejected-order-ajaxcall', [RejectedOrderController::class, 'ajaxcall'])->name('rejected-order-ajaxcall1');
    });
});