<?php

namespace App\Http\Controllers\Customer;

use App\Events\CustomerOrder;
use App\Helper\JwtHelper;
use App\Http\Controllers\Controller;
use App\Mail\AuthenOrder;
use App\Services\BillService;
use App\Services\PaymentService;
use App\Services\ShowTimeService;
use App\Services\TicketService;
use App\Services\UserService;
use App\Services\VoucherService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Inertia\Inertia;

class PaymentController extends Controller
{
    private const SESSION_KEY = 'order_info';

    private $voucherService;
    private $paymentService;
    private $showTimeService;
    private $userService;
    private $billService;
    private $ticketService;

    public function __construct(
        VoucherService $voucherService,
        PaymentService $paymentService,
        ShowTimeService $showTimeService,
        UserService $userService,
        BillService $billService,
        TicketService $ticketService
    ) {
        $this->voucherService = $voucherService;
        $this->paymentService = $paymentService;
        $this->showTimeService = $showTimeService;
        $this->userService = $userService;
        $this->billService = $billService;
        $this->ticketService = $ticketService;
    }

    public function getInfoCustomer(Request $request)
    {
        $data = $request->all();
        $showtime = $this->showTimeService->getRoomByShowTime($data['showtime_id']);
        session()->put(self::SESSION_KEY, $data);

        return Inertia::render('Customer/ConfirmOrder', [
            'showtime' => $showtime,
            'data' => $data,
        ]);
    }

    public function authenEmail(Request $request)
    {
        $fill = $request->all();
        $fill = $this->voucherService->checkVoucher($fill);
        $data = array_merge($fill, session()->get(self::SESSION_KEY, []));

        try {
            $token = JwtHelper::make($data);
            Mail::to($data['email'])->send(new AuthenOrder($token));
        } catch (\Exception $e) {
            $message = ['error' => __('Có lỗi trong quá trình đặt vé !')];
            return redirect()->back()->with($message);
        }
        return redirect()->route('notication-send-mail');
    }

    public function authenOrder($token)
    {
        $data = $this->checExpiredToken($token);
        try {
            DB::beginTransaction();

            $data = $this->voucherService->applyVoucher($data);
            $user = $this->userService->checkOrderCustomer($data);
            $bill = $this->billService->createBill($user->id, $data);
            $this->ticketService->createTicket($data, $bill->id, $user->id);

            $data['bill_id'] = $bill->id;
            unset($data['seat_id'], $data['seat_name'], $data['expired'], $data['voucher']);

            if ($data['flag_voucher']) {
                $this->voucherService->updateBillId($data);
            }


            $dataUrlPayment = $this->paymentService->createUrlPayment($data);

            DB::commit();

            return redirect()->to($dataUrlPayment['data']);
        } catch (\Exception $e) {
            $message = ['error' => __('Ghế này đã được đặt , Vui lòng chọn ghế khác')];
            DB::rollback();
            return redirect()->route('home')->with($message);
        }

        session()->forget(self::SESSION_KEY);
    }

    public function checExpiredToken($token)
    {
        if (JwtHelper::isExpired($token) === true) {
            $message = ['error' => __('Token đã hết hạn . Vui lòng đặt lại vé khác !')];
            return redirect()->route("home")->with($message);
        }

        return JwtHelper::parse($token);
    }

    public function vnpayReturn(Request $request)
    {
        // event(new CustomerOrder($bill, $user));
        // return redirect()->route('order-success', $bill->id);

        // dd($request->all());

        $fill = $request->all();

        $inputData = array();
        $returnData = array();

        foreach ($fill as $key => $value) {
            if (substr($key, 0, 4) == "vnp_") {
                $inputData[$key] = $value;
            }
        }


        $vnp_SecureHash = $inputData['vnp_SecureHash'];
        unset($inputData['vnp_SecureHash']);
        ksort($inputData);
        $i = 0;
        $hashData = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashData = $hashData . '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashData = $hashData . urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
        }

        $vnp_HashSecret = config('vnp.vnp_hash');
        $secureHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);
        $vnpTranId = $inputData['vnp_TransactionNo']; //Mã giao dịch tại VNPAY
        $vnp_BankCode = $inputData['vnp_BankCode']; //Ngân hàng thanh toán
        $vnp_Amount = $inputData['vnp_Amount'] / 100; // Số tiền thanh toán VNPAY phản hồi

        $Status = 0; // Là trạng thái thanh toán của giao dịch chưa có IPN lưu tại hệ thống của merchant chiều khởi tạo URL thanh toán.
        $orderId = $inputData['vnp_TxnRef'];



        try {
            //Check Orderid    
            //Kiểm tra checksum của dữ liệu
            if ($secureHash == $vnp_SecureHash) {
                //Lấy thông tin đơn hàng lưu trong Database và kiểm tra trạng thái của đơn hàng, mã đơn hàng là: $orderId            
                //Việc kiểm tra trạng thái của đơn hàng giúp hệ thống không xử lý trùng lặp, xử lý nhiều lần một giao dịch
                //Giả sử: $order = mysqli_fetch_assoc($result);   

                $order = NULL;
                if ($order != NULL) {
                    if ($order["Amount"] == $vnp_Amount) //Kiểm tra số tiền thanh toán của giao dịch: giả sử số tiền kiểm tra là đúng. //$order["Amount"] == $vnp_Amount
                    {
                        if ($order["Status"] != NULL && $order["Status"] == 0) {
                            if ($inputData['vnp_ResponseCode'] == '00' || $inputData['vnp_TransactionStatus'] == '00') {
                                $Status = 1; // Trạng thái thanh toán thành công
                            } else {
                                $Status = 2; // Trạng thái thanh toán thất bại / lỗi
                            }
                            //Cài đặt Code cập nhật kết quả thanh toán, tình trạng đơn hàng vào DB
                            //
                            //
                            //
                            //Trả kết quả về cho VNPAY: Website/APP TMĐT ghi nhận yêu cầu thành công                
                            $returnData['RspCode'] = '00';
                            $returnData['Message'] = 'Confirm Success';
                        } else {
                            $returnData['RspCode'] = '02';
                            $returnData['Message'] = 'Order already confirmed';
                        }
                    } else {
                        $returnData['RspCode'] = '04';
                        $returnData['Message'] = 'invalid amount';
                    }
                } else {
                    $returnData['RspCode'] = '01';
                    $returnData['Message'] = 'Order not found';
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
        //Trả lại VNPAY theo định dạng JSON
        // echo json_encode($returnData);


        dd($inputData, 666, $hashData, $returnData, $Status);
    }
}
