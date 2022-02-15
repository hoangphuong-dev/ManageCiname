<?php

namespace App\Repositories;

use App\Models\Seat;
use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;
//use Your Model

/**
 * Class SeatRepository.
 */
class SeatRepository extends BaseRepository
{
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        return Seat::class;
    }

    public function createSeat($data, $room_id)
    {
        foreach ($data as $item) {
            $this->model->create([
                'room_id' => $room_id,
                'seat_type_id' => $item['seat_type'],
                'row_name' => $item['row'],
                'columns_number' => $item['column'],
            ]);
        }
    }
}
