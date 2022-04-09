<?php

namespace App\Services;

use App\Http\Resources\RoomResource;
use Illuminate\Support\Facades\DB;
use App\Repositories\RoomRepository;
use App\Repositories\SeatRepository;

class RoomService extends BaseService
{
    protected $roomRepository;
    protected $seatRepository;

    public function __construct(RoomRepository $roomRepository, SeatRepository $seatRepository)
    {
        $this->roomRepository = $roomRepository;
        $this->seatRepository = $seatRepository;
    }

    public function getRoomByCinema($id_cinema)
    {
        return $this->roomRepository->getRoomByCinema($id_cinema);
    }

    public function store($request)
    {
        $data = $request->validated();
        try {
            DB::beginTransaction();
            $room = $this->roomRepository->createRooom($data);

            $this->seatRepository->createSeat($data['seats'], $room->id);

            // $user->load('adminInfo');

            DB::commit();
            return $room;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function delete($id)
    {
        return $this->roomRepository->destroy($id);
    }

    public function list($request)
    {
        $rooms = $this->roomRepository->list($request);
        return RoomResource::collection($rooms);
    }

    public function updateStatus($id, $request)
    {
        return $this->roomRepository->updateStatus($id, $request);
    }
}
