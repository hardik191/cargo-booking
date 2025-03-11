<?php

use App\Models\SystemSetting;
use App\Models\UserDetail;
use Carbon\Carbon;

function enterDateforment($date, $format = 'd-m-Y H:i A')
{
    return $date ? Carbon::parse($date)->format($format) : '';
}

function new_date_time_br_formate($date)
{
    $date_format = Carbon::parse($date)->format('d-M-Y');
    $time_format = Carbon::parse($date)->format('h:i:s A');

    return $date_format . '<br>' . $time_format;
}

function date_formate($date){
    return date("d-M-Y", strtotime($date));
}

function date_small_formate($date){
    return date("d-m-Y", strtotime($date));
}

function convert_indian_currency($amount){
      $amt = '₹'. IND_money_format($amount);

      return $amt;
}

function ind_money_format($money){

    $decimal = (string)($money - floor($money));
    $money = floor($money);
    $length = strlen($money);
    $m = '';
    $money = strrev($money);
    for($i=0;$i<$length;$i++){
        if(( $i==3 || ($i>3 && ($i-1)%2==0) )&& $i!=$length){
            $m .=',';
        }
        $m .=$money[$i];
    }
    $result = strrev($m);
    $decimal = preg_replace("/0\./i", ".", $decimal);
    $decimal = substr($decimal, 0, 3);
    if( $decimal != '0'){
    $result = $result.$decimal;
    }
    return $result;
}

function rupees_fromate($amount){
        // Format the amount with commas as thousands separators and two decimal places
    $formattedAmount = number_format($amount, 2, '.', ',');

    // Concatenate the currency symbol (Indian Rupees) with the formatted amount
    $indianRupees = '₹' . $formattedAmount;

    return $indianRupees;
}

function aadhar_formate($aadhar_no){
    $formatted_aadhar = substr_replace($aadhar_no, '-', 4, 0);
    $formatted_aadhar = substr_replace($formatted_aadhar, '-', 9, 0);
    return $formatted_aadhar;
}

function date_time_formate($date){
    return date("d/m/Y h:i:s A", strtotime($date));
}

function ccd($value){
    echo "<pre>"; print_r($value); die();
}

function numberformat($value){
    return number_format((float)$value, 2, '.', '');
}

function get_system_setting($key){
    $objSystemSetting = SystemSetting::where('key', $key)->first();

    return $objSystemSetting;
}

function get_system_setting_val($key)
{
    // ccd($key);
    $objSystemSetting = SystemSetting::where('key', $key)->first();

    $data = json_decode($objSystemSetting->value);

    return $data;
}

function get_system_name(){
    $objSystemSetting = SystemSetting::where('key', 'general_setting')->first();

    if ($objSystemSetting) {
        return json_decode($objSystemSetting->value)->system_name ?? 'Project';
    }

    return 'Project';
}

function generateCustomerCode()
{
    $prefix = 'CUS-';

    // Get the latest user_code in the database
    $latestUserCode = UserDetail::where('user_code', 'like', $prefix . '%')
        ->orderBy('user_code', 'desc')
        ->first();

    // If there is a latest user_code, extract the numeric part and increment it
    if ($latestUserCode) {
        // Extract the numeric part of the code (EMP-01 -> 01)
        $lastNumber = intval(str_replace($prefix, '', $latestUserCode->user_code));

        // Increment the number
        $newNumber = $lastNumber + 1;
    } else {
        // Start with 1 if no existing code is found
        $newNumber = 1;
    }

    // Generate the new user_code, zero-padded to 2 digits (EMP-01, EMP-02, etc.)
    $newCode = $prefix . str_pad($newNumber, 2, '0', STR_PAD_LEFT);

    // Check if the generated code already exists and ensure uniqueness
    while (UserDetail::where('user_code', $newCode)->exists()) {
        $newNumber++;
        $newCode = $prefix . str_pad($newNumber, 2, '0', STR_PAD_LEFT);
    }

    return $newCode;
}

function get_payment_mode($mode_id)
{
    $statuses = config('constants.PAYMENT_MODE');
    return $statuses[$mode_id] ?? 'N/A';

}
function get_order_status($status_id)
{
    $statuses = config('constants.HISTORY_ORDER_STATUS');
    return $statuses[$status_id] ?? null;
}

?>
