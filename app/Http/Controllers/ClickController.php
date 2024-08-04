<?php

namespace App\Http\Controllers;

use App\Models\ClickUz;
use App\Models\Order;
use Illuminate\Http\Request;

class ClickController extends Controller
{
    public function prepare(Request $request)
    {

        // \Log::info('Prepare',[$request->all()]);
        $clickTransId = $request->input('click_trans_id');
        $serviceId = $request->input('service_id');
        $clickPaydocId = $request->input('click_paydoc_id');
        $merchantTransId = $request->input('merchant_trans_id');
        $amount = $request->input('amount');
        $action = $request->input('action');
        $error = $request->input('error');
        $errorNote = $request->input('error_note');
        $signTime = $request->input('sign_time');
        $signString = $request->input('sign_string');
        $secretKey = 'GFwdmEQpHp5';

        $generatedSignString = md5($clickTransId . $serviceId . $secretKey . $merchantTransId . $amount . $action . $signTime);

        if ($signString !== $generatedSignString) {
            return response()->json(['error' => -1, 'error_note' => 'Invalid sign_string']);
        }

        ClickUz::create([
            'click_trans_id' => $clickTransId,
            'merchant_trans_id' => $merchantTransId,
            'amount' => $amount,
            'amount_rub' => $amount,
            'sign_time' => $signTime,
            'situation' => $error
        ]);

        if ($error == 0) {
            $response = [
                'click_trans_id' => $clickTransId,
                'merchant_trans_id' => $merchantTransId,
                'merchant_prepare_id' => $merchantTransId,
                'error' => 0,
                'error_note' => 'Payment prepared successfully',
            ];
        } else {
            $response = [
                'click_trans_id' => $clickTransId,
                'merchant_trans_id' => $merchantTransId,
                'merchant_prepare_id' => $merchantTransId,
                'error' => -9,
                'error_note' => 'Do not find a user!!!',
            ];
        }

        // \Log::info('Click Prepare Response:', $response);

        return response()->json($response);
    }
    public function complete(Request $request)
    {
        $clickTransId = $request->input('click_trans_id');
        $serviceId = $request->input('service_id');
        $clickPaydocId = $request->input('click_paydoc_id');
        $merchantTransId = $request->input('merchant_trans_id');
        $merchantPrepareId = $request->input('merchant_prepare_id');
        $amount = $request->input('amount');
        $action = $request->input('action');
        $error = $request->input('error');
        $errorNote = $request->input('error_note');
        $signTime = $request->input('sign_time');
        $signString = $request->input('sign_string');
        $secretKey = 'GFwdmEQpHp5';
        // $secretKey = env('MERCHANT_KEY'); 

        $generatedSignString = md5($clickTransId . $serviceId . $secretKey . $merchantTransId . $merchantPrepareId . $amount . $action . $signTime);

        if ($signString !== $generatedSignString) {
            return response()->json(['error' => -1, 'error_note' => 'Invalid sign_string']);
        }

        if ($error == 0) {
            ClickUz::where('click_trans_id', $clickTransId)->update(['situation' => 1, 'status' => 'success']);
            Order::where('id', $merchantTransId)->update(['status' => 'yakunlandi']); // Retrieve the Order
            $order = Order::find($merchantPrepareId);
            return response()->json([
                'click_trans_id' => $clickTransId,
                'merchant_trans_id' => $merchantTransId,
                'merchant_confirm_id' => $merchantTransId,
                'error' => 0,
                'error_note' => 'Payment Success'
            ]);
        } else {
            ClickUz::where('click_trans_id', $clickTransId)->update(['situation' => -9, 'status' => 'error']);
            Order::where('id', $merchantTransId)->update(['status' => 'bekor qilingan']);
            return response()->json([
                'click_trans_id' => $clickTransId,
                'merchant_trans_id' => $merchantTransId,
                'merchant_confirm_id' => $merchantTransId,
                'error' => -9,
                'error_note' => 'Do not find a user!!!'
            ]);
        }
    }
}
