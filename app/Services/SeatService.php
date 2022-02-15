<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Repositories\RoomRepository;
use App\Repositories\SeatRepository;

class SeatService extends BaseService
{
    protected $seatRepository;

    public function __construct(SeatRepository $seatRepository)
    {
        $this->seatRepository = $seatRepository;
    }
}
