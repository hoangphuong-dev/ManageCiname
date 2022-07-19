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
        $inputData['vnp_Amount'] = $inputData['vnp_Amount'] / 100; // Số tiền thanh toán VNPAY phản hồi
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
            '00' => 'Giao dịch thành công',
            '07' => 'Trừ tiền thành công. Giao dịch bị nghi ngờ (liên quan tới lừa đảo, giao dịch bất thường).',
            '09' => 'Giao dịch không thành công do: Thẻ/Tài khoản của khách hàng chưa đăng ký dịch vụ InternetBanking tại ngân hàng.',
            '10' => 'Giao dịch không thành công do: Khách hàng xác thực thông tin thẻ/tài khoản không đúng quá 3 lần',
            '11' => 'Giao dịch không thành công do: Đã hết hạn chờ thanh toán. Xin quý khách vui lòng thực hiện lại giao dịch.',
            '12' => 'Giao dịch không thành công do: Thẻ/Tài khoản của khách hàng bị khóa.',
            '13' => 'Giao dịch không thành công do Quý khách nhập sai mật khẩu xác thực giao dịch (OTP). Xin quý khách vui lòng thực hiện lại giao dịch.',
            '24' => 'Giao dịch không thành công do: Khách hàng hủy giao dịch',
            '51' => 'Giao dịch không thành công do: Tài khoản của quý khách không đủ số dư để thực hiện giao dịch.',
            '65' => 'Giao dịch không thành công do: Tài khoản của Quý khách đã vượt quá hạn mức giao dịch trong ngày.',
            '75' => 'Ngân hàng thanh toán đang bảo trì.',
            '79' => 'Giao dịch không thành công do: KH nhập sai mật khẩu thanh toán quá số lần quy định. Xin quý khách vui lòng thực hiện lại giao dịch',
            '02' => 'Merchant không hợp lệ (kiểm tra lại vnp_TmnCode)',
            '03' => 'Dữ liệu gửi sang không đúng định dạng',
            '91' => 'Không tìm thấy giao dịch yêu cầu',
            '94' => 'Yêu cầu bị trùng lặp trong thời gian giới hạn của API (Giới hạn trong 5 phút)',
            '97' => 'Chữ ký không hợp lệ',
            '99' => 'Có lỗi xảy ra trong quá trình thanh toán . Vui lòng thử lại !',
            '01' => 'Không tìm thấy đơn hàng cần thanh toán',
            '04' => 'Số tiền thanh toán không phù hợp',
            '09' => 'Đơn hàng của bạn đã được thanh toán',
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
