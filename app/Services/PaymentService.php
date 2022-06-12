<?php

namespace App\Services;

use Exception;

/**
 * Class PaymentService
 * @package App\Services
 */
class PaymentService
{
    public function createUrlPayment($fill)
    {
        $exprice_date = date('YmdHis', strtotime('+15 minutes', strtotime(date("YmdHis"))));

        $vnp_Url = config('vnp.vnp_url');
        $vnp_HashSecret = config('vnp.vnp_hash');

        $inputData = array(
            "vnp_Version" => "2.1.0",
            "vnp_ExpireDate" => $exprice_date,
            "vnp_TmnCode" => config('vnp.vnp_code'),
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $_SERVER['REMOTE_ADDR'],
            "vnp_Locale" => 'vn',
            "vnp_ReturnUrl" => route('order.vnpayReturn'),
            "vnp_Amount" => $fill['total_money'] * 100,
            "vnp_TxnRef" => $fill['bill_id'],
            "vnp_Bill_Mobile" => $fill['phone'],
            "vnp_Bill_Email" => $fill['email'],
            "vnp_Command" => "pay",
            "vnp_OrderInfo" => 'Paying for movie tickets',
            "vnp_OrderType" => 'billpayment',
        );

        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnp_Url = $vnp_Url . "?" . $query;

        if (isset($vnp_HashSecret)) {
            $vnpSecureHash =   hash_hmac('sha512', $hashdata, $vnp_HashSecret);
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }
        $returnData = array(
            'code' => '00', 'message' => 'success', 'data' => $vnp_Url
        );

        return $returnData;
    }
}