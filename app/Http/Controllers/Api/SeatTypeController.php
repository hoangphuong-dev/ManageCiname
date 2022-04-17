<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SeatTypeRequest;
use App\Services\SeatTypeService;
use Illuminate\Http\Request;

class SeatTypeController extends Controller
{
    protected $seatTypeService;

    public function __construct(SeatTypeService $seatTypeService)
    {
        $this->seatTypeService = $seatTypeService;
    }

    public function index(Request $request)
    {
        return $this->seatTypeService->list($request);
    }

    public function store(SeatTypeRequest $request)
    {
        dd($request->all());
        try {
            $this->seatTypeService->store($request);
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
