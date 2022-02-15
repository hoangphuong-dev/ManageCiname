<?php

namespace App\Repositories;

use App\Models\Room;
use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;
//use Your Model

/**
 * Class RoomRepository.
 */
class RoomRepository extends BaseRepository
{
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        return Room::class;
    }

    public function make($fillable)
    {
        return $this->model->create($fillable);
    }

    public function createRooom($data)
    {
        return $this->make([
            'name' => $data['name'],
            'cinema_id' => $data['cinema_id'],
            'row_number' => $data['row_number'],
            'column_number' => $data['column_number'],
            'status' => Room::STATUS_OPEN,
        ]);
    }
}
