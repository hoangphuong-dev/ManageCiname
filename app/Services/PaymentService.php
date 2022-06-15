<?php

namespace App\Services;

use App\Repositories\PaymentRepository;
use Exception;

/**
 * Class PaymentService
 * @package App\Services
 */
class PaymentService
{
    private $paymentRepository;
    private $billService;

    public function __construct(
        PaymentRepository $paymentRepository,
        BillService $billService,
    ) {
        $this->paymentRepository = $paymentRepository;
        $this->billService = $billService;
    }

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

    private function getDataVnpay($fill)
    {
        $inputData = array();
        foreach ($fill as $key => $value) {
            if (substr($key, 0, 4) == "vnp_") {
                $inputData[$key] = $value;
            }
        }
        return $inputData;
    }

    private function getHashData($data)
    {
        ksort($data);
        $i = 0;
        $hashData = "";
        foreach ($data as $key => $value) {
            if ($i == 1) {
                $hashData = $hashData . '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashData = $hashData . urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
        }

        return $hashData;
    }

    public function vnpayReturn($fill)
    {
        $returnData = [];
        $vnp_HashSecret = config('vnp.vnp_hash');
        $inputData = $this->getDataVnpay($fill);
        $vnp_SecureHash = $inputData['vnp_SecureHash'];
        unset($inputData['vnp_SecureHash']);
        $hashData = $this->getHashData($inputData);

        $secureHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);
        $inputData['vnp_Amount'] = $inputData['vnp_Amount'] / 100; // Số tiền thanh toán VNPAY phản hồi
        try {
            if ($secureHash == $vnp_SecureHash) {
                $bill = $this->billService->getBillById($inputData['vnp_TxnRef']);
                if (!(is_null($bill))) {
                    if ($bill->total_money == $inputData['vnp_Amount']) {
                        if ($bill->status == 0) {
                            if ($inputData['vnp_ResponseCode'] == '00' || $inputData['vnp_TransactionStatus'] == '00') {
                                $this->paymentRepository->make($inputData);
                                $returnData['RspCode'] = '00';
                                $returnData['Message'] = 'Confirm Success';
                            }
                        } else {
                            $returnData['RspCode'] = '02';
                            $returnData['Message'] = 'Đơn hàng của bạn đã được thanh toán !';
                        }
                    } else {
                        $returnData['RspCode'] = '04';
                        $returnData['Message'] = 'Số tiền thanh toán không phù hợp ';
                    }
                } else {
                    $returnData['RspCode'] = '01';
                    $returnData['Message'] = 'Không tìm thấy đơn hàng cần thanh toán';
                }
            } else {
                $returnData['RspCode'] = '97';
                $returnData['Message'] = 'Invalid signature';
            }
        } catch (Exception $e) {
            dd($e);
            $returnData['RspCode'] = '99';
            $returnData['Message'] = 'Unknow error';
        }
        return $returnData;
    }
}