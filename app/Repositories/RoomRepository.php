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

    public function getRoomByCinema($id_cinema)
    {
        return $this->model->newQuery()
            ->select('id', 'name')
            ->where('cinema_id', $id_cinema)
            ->where('status', Room::STATUS_OPEN)
            ->get()->toArray();
    }

    public function createRooom($data)
    {
        return $this->make([
            'name' => $data['name'],
            'cinema_id' => $data['cinema_id'],
            'row_number' => $data['row_number'],
            'column_number' => $data['column_number'],
            'format_movie_id' => $data['format'],
            'status' => Room::STATUS_OPEN,
        ]);
    }

    public function destroy($id)
    {
        return $this->model->where('id', $id)->where('status', Room::STATUS_CLOSE)->delete();
    }

    public function list($request)
    {
        return $this->model->query()

            ->when($request->name, function ($query) use ($request) {
                return $query->where("name", "like", "%{$request->name}%");
            })
            ->where('cinema_id', $request->cinema_id)
            ->orderBy('created_at', 'DESC')
            ->paginate($request->query('limit', 12));
    }
    public function updateStatus($id, $request)
    {
        $status = $request->status;
        return $this->model->where('id', $id)->update(['status' => $status]);
    }
}
