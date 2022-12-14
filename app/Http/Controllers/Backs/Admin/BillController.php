<?php

namespace App\Http\Controllers\Backs\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bill;
use App\Models\Ticket;
use App\Services\BillService;
use App\Services\CinemaService;
use App\Services\TicketService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class BillController extends Controller
{
    public $billService;

    public function __construct(BillService $billService)
    {
        $this->billService = $billService;
    }

    public function getBillById($id)
    {
        $bill = Ticket::with(['showtime' => function ($q) {
            $q->with(['movie', 'room']);
        }])->where('bill_id', $id)->first();

        $tickets = Ticket::with(['seat' => function ($q) {
            $q->with(['seat_type']);
        }])->where('bill_id', $id)->get();

        $arr = [
            'bill' => $bill,
            'tickets' => $tickets,
        ];
        return $arr;
    }


    public function getBillByAdmin(Request $request)
    {
        $admin = Auth::guard('admin')->user();
        try {
            $bills = $this->billService->getBillByAdmin($admin->id, $request);
            return Inertia::render('Backs/Admin/Bill', [
                'bills' => $bills,
                'filtersBE' => $request->all(),
            ]);
        } catch (\Exception $e) {
            $message = ['error' => __('Có lỗi trong quá trình thực thi !')];
            return back()->with($message);
        }
    }
}
