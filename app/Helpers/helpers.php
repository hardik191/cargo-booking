<?php

use App\Models\SystemSetting;

function date_formate($date){
    return date("d-M-Y", strtotime($date));
}

function new_date_formate($date){
    return date("d/m/Y", strtotime($date));
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
?>
