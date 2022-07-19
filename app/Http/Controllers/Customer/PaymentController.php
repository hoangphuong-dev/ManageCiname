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
    private const SESSION_USER = 'user_order';

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
        if (empty($data)) {
            abort(404);
        }
        $showtime = $this->showTimeService->getRoomByShowTime($data['show_time_id']);
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
            dd($e);
            $message = ['error' => __('Có lỗi trong quá trình đặt vé !')];
            return redirect()->back()->with($message);
        }
        return redirect()->route('notication-send-mail');
    }

    public function authenOrder($token)
    {
        if (JwtHelper::isExpired($token) === true) {
            $message = ['error' => __('Token đã hết hạn . Vui lòng đặt lại vé khác !')];
            return redirect()->route("home")->with($message);
        }

        $data = JwtHelper::parse($token);

        try {
            DB::beginTransaction();

            $data = $this->voucherService->applyVoucher($data);
            $user = $this->userService->checkOrderCustomer($data);
            $bill = $this->billService->createBill($user->id, $data);
            $ticket = $this->ticketService->createTicket($data, $bill->id, $user->id);

            session()->put(self::SESSION_USER, [
                'user' => $user,
                'bill' => $bill,
                'ticket' => $ticket,
                'voucher_id' => isset($data['voucher_id']) ? $data['voucher_id'] : null
            ]);

            $data['bill_id'] = $bill->id;
            unset($data['seat_id'], $data['seat_name'], $data['expired'], $data['voucher']);

            if ($data['flag_voucher']) {
                $this->voucherService->updateBillId($data);
            }
            $dataUrlPayment = $this->paymentService->createUrlPayment($data);

            DB::commit();
            session()->forget(self::SESSION_KEY);
            return redirect()->to($dataUrlPayment['data']);
        } catch (\Exception $e) {
            dd($e);
            $message = ['error' => __('Ghế này đã được đặt , Vui lòng chọn ghế khác')];
            DB::rollback();
            return redirect()->route('home')->with($message);
        }
    }

    public function vnpayReturn(Request $request)
    {
        $fill = $request->all();
        $result = $this->paymentService->vnpayReturn($fill);

        $getSession = session()->get(self::SESSION_USER, []);

        $bill = $getSession['bill'];

        if ($result['resCode'] == '00') {
            $this->billService->updateStatus($bill->id);
            event(new CustomerOrder($bill, $getSession['user']));
            return redirect()->route('order-success', $bill->id);
        } else {
            try {
                DB::beginTransaction();

                $this->ticketService->deleteMultipleById($getSession['ticket']);

                if (!is_null($getSession['voucher_id'])) {
                    $this->voucherService->destroyUsed($getSession['voucher_id']);
                }

                $this->billService->deleteById($bill->id);

                DB::commit();
            } catch (\Exception $e) {
                dd($e);
                DB::rollback();
            }

            return redirect()->route('home')->with(['error' => __($result['message'])]);
        }
    }
}
