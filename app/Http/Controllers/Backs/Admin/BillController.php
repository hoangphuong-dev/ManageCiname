<?php

namespace App\Http\Controllers\Backs\Admin;

use App\Http\Controllers\Controller;
use App\Services\BillService;
use App\Services\CinemaService;
use App\Services\TicketService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class BillController extends Controller
{
    public $cinemaService;
    public $billService;

    public function __construct(CinemaService $cinemaService, BillService $billService)
    {
        $this->cinemaService = $cinemaService;
        $this->billService = $billService;
    }

    public function index(Request $request)
    {
        $admin = Auth::guard('admin')->user();

        // $cinema = $this->cinemaService->getCinemaByIdAdmin($admin->id);

        $bills = $this->billService->getBillByCinema($admin->id, $request);

        return Inertia::render('Backs/Admin/Bill', [
            'bills' => $bills,
        ]);
    }
}
