<?php

namespace App\Services;

use App\Repositories\PaymentRepository;
use Carbon\Carbon;
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
        $vnp_Url = config('vnp.vnp_url');
        $vnp_HashSecret = config('vnp.vnp_hash');

        $inputData = array(
            "vnp_Version" => "2.1.0",
            "vnp_ExpireDate" => Carbon::now()->addMinute(15)->format('YmdHis'),
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
        $responseCode = '';
        $vnp_HashSecret = config('vnp.vnp_hash');
        $inputData = $this->getDataVnpay($fill);
        $vnp_SecureHash = $inputData['vnp_SecureHash'];
        unset($inputData['vnp_SecureHash']);
        $hashData = $this->getHashData($inputData);

        $secureHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);
        $inputData['vnp_Amount'] = $inputData['vnp_Amount'] / 100; // S??? ti???n thanh to??n VNPAY ph???n h???i
        try {
            if ($secureHash == $vnp_SecureHash) {
                $bill = $this->billService->getBillById($inputData['vnp_TxnRef']);
                if (!(is_null($bill))) {
                    if ($bill->total_money == $inputData['vnp_Amount']) {
                        if ($bill->status == 2) {
                            if ($inputData['vnp_ResponseCode'] == '00' || $inputData['vnp_TransactionStatus'] == '00') {
                                $this->paymentRepository->make($inputData);
                                $responseCode = '00';
                            }
                        } else $responseCode = '09';
                    } else $responseCode = '04';
                } else $responseCode = '01';
            }
        } catch (Exception $e) {
            dd($e);
            $responseCode = '99';
        }
        if ($responseCode == "") {
            $responseCode = $inputData['vnp_ResponseCode'];
        }

        return $this->getResponVnp($responseCode);
    }

    public function getResponVnp($resCode)
    {
        $dataErr = [
            '00' => 'Giao d???ch th??nh c??ng',
            '07' => 'Tr??? ti???n th??nh c??ng. Giao d???ch b??? nghi ng??? (li??n quan t???i l???a ?????o, giao d???ch b???t th?????ng).',
            '09' => 'Giao d???ch kh??ng th??nh c??ng do: Th???/T??i kho???n c???a kh??ch h??ng ch??a ????ng k?? d???ch v??? InternetBanking t???i ng??n h??ng.',
            '10' => 'Giao d???ch kh??ng th??nh c??ng do: Kh??ch h??ng x??c th???c th??ng tin th???/t??i kho???n kh??ng ????ng qu?? 3 l???n',
            '11' => 'Giao d???ch kh??ng th??nh c??ng do: ???? h???t h???n ch??? thanh to??n. Xin qu?? kh??ch vui l??ng th???c hi???n l???i giao d???ch.',
            '12' => 'Giao d???ch kh??ng th??nh c??ng do: Th???/T??i kho???n c???a kh??ch h??ng b??? kh??a.',
            '13' => 'Giao d???ch kh??ng th??nh c??ng do Qu?? kh??ch nh???p sai m???t kh???u x??c th???c giao d???ch (OTP). Xin qu?? kh??ch vui l??ng th???c hi???n l???i giao d???ch.',
            '24' => 'Giao d???ch kh??ng th??nh c??ng do: Kh??ch h??ng h???y giao d???ch',
            '51' => 'Giao d???ch kh??ng th??nh c??ng do: T??i kho???n c???a qu?? kh??ch kh??ng ????? s??? d?? ????? th???c hi???n giao d???ch.',
            '65' => 'Giao d???ch kh??ng th??nh c??ng do: T??i kho???n c???a Qu?? kh??ch ???? v?????t qu?? h???n m???c giao d???ch trong ng??y.',
            '75' => 'Ng??n h??ng thanh to??n ??ang b???o tr??.',
            '79' => 'Giao d???ch kh??ng th??nh c??ng do: KH nh???p sai m???t kh???u thanh to??n qu?? s??? l???n quy ?????nh. Xin qu?? kh??ch vui l??ng th???c hi???n l???i giao d???ch',
            '02' => 'Merchant kh??ng h???p l??? (ki???m tra l???i vnp_TmnCode)',
            '03' => 'D??? li???u g???i sang kh??ng ????ng ?????nh d???ng',
            '91' => 'Kh??ng t??m th???y giao d???ch y??u c???u',
            '94' => 'Y??u c???u b??? tr??ng l???p trong th???i gian gi???i h???n c???a API (Gi???i h???n trong 5 ph??t)',
            '97' => 'Ch??? k?? kh??ng h???p l???',
            '99' => 'C?? l???i x???y ra trong qu?? tr??nh thanh to??n . Vui l??ng th??? l???i !',
            '01' => 'Kh??ng t??m th???y ????n h??ng c???n thanh to??n',
            '04' => 'S??? ti???n thanh to??n kh??ng ph?? h???p',
            '09' => '????n h??ng c???a b???n ???? ???????c thanh to??n',
        ];

        foreach ($dataErr as $key => $text) {
            if ($resCode == $key) {
                return [
                    'resCode' => $key,
                    'message' => $text,
                ];
            }
        }
    }
}
