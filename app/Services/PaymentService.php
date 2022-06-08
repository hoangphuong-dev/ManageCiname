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

        // dd($exprice_date);

        $vnp_Url = config('vnp.vnp_url');
        $vnp_HashSecret = config('vnp.vnp_hash');

        $inputData = array(
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => config('vnp.vnp_code'),
            "vnp_Amount" => $fill['amount'] * 100,
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $_SERVER['REMOTE_ADDR'],
            "vnp_Locale" => $fill['language'],
            "vnp_ReturnUrl" => route('vnpayReturn'),
            "vnp_TxnRef" => $fill['order_id'],
            "vnp_ExpireDate" => $exprice_date,
            "vnp_Bill_Mobile" => $fill['txt_billing_mobile'],
            "vnp_Bill_Email" => $fill['txt_billing_email'],
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