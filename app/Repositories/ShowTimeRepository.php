<?php

namespace App\Repositories;

use App\Models\ShowTime;
use App\Models\ViewShowTimeByDay;
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

    public function createShowTime($data)
    {
        $this->model->create([
            'movie_id' => $data['movie_id'],
            'room_id' => $data['romm_id'],
            'time_start' => $data['time_start'],
            'time_end' => $data['time_end'],
        ]);
    }

    public function listShowTimeByCinema($cinema_id, $request)
    {
        return $this->model
            ->join("rooms", "rooms.id", "=", "show_times.room_id")
            // ->when($request->name, function ($query) use ($request) {
            //     return $query->where("name", "like", "%{$request->name}%");
            // })
            ->where('rooms.cinema_id', $cinema_id)
            ->where('time_start', '>=', now())
            ->get();
    }

    public function list($request, $cinema_id)
    {
        return ViewShowTimeByDay::query()
            ->when($request->name, function ($query) use ($request) {
                return $query->where("name", "like", "%{$request->name}%");
            })
            ->where('cinema_id', $cinema_id)
            ->orderBy('day')
            ->paginate($request->query('limit', 12));
    }

    public function listShowTimeByRoom($roomId, $request)
    {
        return $this->model->query()
            ->select("show_times.*", "movies.name")
            ->join("movies", "movies.id", "=", "show_times.movie_id")
            // ->when($request->name, function ($query) use ($request) {
            //     return $query->where("name", "like", "%{$request->name}%");
            // })
            ->where('room_id', $roomId)->get();
    }

    public function getShowTimeByMovieDay($cinema_id, $movie_id, $day)
    {
        return $this->model->newQuery()
            ->select('show_times.*', 'rooms.name', 'rooms.row_number', 'rooms.column_number')
            ->selectRaw('DATE_FORMAT(time_start, "%H:%i") as time')
            ->where('movie_id', $movie_id)
            ->where('cinema_id', $cinema_id)
            ->whereRaw('DATE_FORMAT(time_start, "%d-%m-%Y") like "' . $day . '"')
            ->join('rooms', 'rooms.id', '=', 'show_times.room_id')
            ->get();
    }
}
