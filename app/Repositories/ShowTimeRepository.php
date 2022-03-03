<?php

namespace App\Repositories;

use App\Models\ShowTime;
use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;
//use Your Model

/**
 * Class ShowTimeRepository.
 */
class ShowTimeRepository extends BaseRepository
{
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        return ShowTime::class;
    }

    public function  createShowTime($data)
    {
        foreach ($data['schedule'] as $item) {
            $this->model->create([
                'movie_id' => $data['movie'],
                'room_id' => $item['room'],
                'time_start' => $data['date'] . ' ' . $item['time_start'],
            ]);
        }
    }

    public function list($request)
    {
        return $this->model->get();
        // return $this->model->query()

        //     ->when($request->name, function ($query) use ($request) {
        //         return $query->where("name", "like", "%{$request->name}%");
        //     })
        //     ->join('rooms', 'rooms.id', '=', 'show_times.room_id')
        //     ->where('rooms.cinema_id', $request->cinema_id)
        //     ->paginate($request->query('limit', 10));
    }
}
