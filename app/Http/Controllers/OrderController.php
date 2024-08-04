<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function generateClickUrl($order_id = 1, $orderTotal = 1000)
    {
        $serviceId = '12345';
        $merchantId = '12345';
        $clickUrl = "https://my.click.uz/services/pay";
        $clickUrl .= "?service_id=$serviceId&merchant_id=$merchantId";
        $clickUrl .= "&amount=$orderTotal&transaction_param=$order_id";

        return $clickUrl;
    }
}
