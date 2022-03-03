<?php

namespace App\Services;

use App\Http\Resources\ShowTimeResource;
use App\Repositories\ShowTimeRepository;
use Illuminate\Support\Facades\DB;

class ShowTimeService extends BaseService
{
    protected $showTimeRepository;

    public function __construct(ShowTimeRepository $showTimeRepository)
    {
        $this->showTimeRepository = $showTimeRepository;
    }

    public function store($request)
    {

        $data = $request->validated();
        try {
            DB::beginTransaction();
            $show_time = $this->showTimeRepository->createShowTime($data);

            // $this->seatRepository->createSeat($data['seats'], $room->id);

            // $user->load('adminInfo');

            DB::commit();
            return $show_time;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function list($request)
    {
        $showtimes = $this->showTimeRepository->list($request);
        return ShowTimeResource::collection($showtimes);
    }
}
