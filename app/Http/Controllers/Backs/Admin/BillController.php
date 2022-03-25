<?php

namespace App\Http\Controllers\Backs\Admin;

use App\Http\Controllers\Controller;
use App\Services\BillService;
use App\Services\TicketService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class BillController extends Controller
{
    public $billService;
    public $ticketService;

    public function __construct(BillService $billService, TicketService $ticketService)
    {
        $this->billService = $billService;
        $this->ticketService = $ticketService;
    }

    public function index(Request $request)
    {


        $admin = Auth::guard('admin')->user();
        // bai toan : Lam the nao de lay ra bill cua rap minh 

        $ticket = $this->ticketService->getTicketByCinema();

        dd($ticket);

        // $bills = $this->billService->getAllBillCinema();
        return Inertia::render('Backs/Admin/Bill');
    }
}
