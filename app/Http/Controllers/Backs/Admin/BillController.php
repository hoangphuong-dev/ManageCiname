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

    public function __construct(CinemaService $cinemaService)
    {
        $this->cinemaService = $cinemaService;
    }

    public function index(Request $request)
    {
        $admin = Auth::guard('admin')->user();

        $cinema = $this->cinemaService->getCinemaByIdAdmin($admin->id);

        return Inertia::render('Backs/Admin/Bill', [
            'cinema' => $cinema,
        ]);
    }
}
