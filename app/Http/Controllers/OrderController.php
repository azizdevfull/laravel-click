<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function generateClickUrl($order_id, $orderTotal)
    {
        $serviceId = '29507';
        $merchantId = '21817';
        $transactionParam = $order_id;
        $clickUrl = "https://my.click.uz/services/pay";
        $clickUrl .= "?service_id=$serviceId&merchant_id=$merchantId";
        $clickUrl .= "&amount=$orderTotal&transaction_param=$transactionParam";

        return $clickUrl;
    }
}
