<?php

namespace App\Http\Controllers\Backs\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\SeatType;
use App\Services\SeatTypeService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SeatTypeController extends Controller
{

    protected $seatTypeService;

    public function __construct(SeatTypeService $seatTypeService)
    {
        $this->seatTypeService = $seatTypeService;
    }

    public function index()
    {
        return Inertia::render('Backs/SuperAdmin/SeatType');
    }

    public function edit(Request $request, $id)
    {
        // return $this->seatTypeService->edit($request, $id);
        $message = ['error' => "Tinh nang nay van dang duoc phat trien them"];
        return back()->with($message);
    }
}
