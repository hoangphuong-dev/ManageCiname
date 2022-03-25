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

    public function checkShowTime($data)
    {

        // lay ra tat ca suat chieu cua ngay duoc truyen vao 
        $showtimes = $this->model->newQuery()
            ->selectRaw('DATE_FORMAT(time_start, "%H:%i") as time_start, DATE_FORMAT(time_end, "%H:%i") as time_end')
            ->where('room_id', $data['room_id'])
            ->whereRaw('DATE_FORMAT(time_start, "%Y-%m-%d") like "' . $data['day'] . '"')
            ->orderBy('time_start')
            ->get()->toArray();

        foreach ($showtimes as $key => $showtime) {
            dd($showtime);
            if ($key != 0) {
                if (strtotime($showtime[$data['time_start']]) < strtotime($showtime[$key - 1][$data['time_end']])) {
                    return true;
                }
            }
        }
        return false;


        // return $this->model->newQuery()
        // ->where('time_start')
        // $start_time_key = "11:00";
        // $end_time_key = "12:00";

        // $periods = [
        //     ["start_time" => "09:00", "end_time" => "10:30"],
        //     ["start_time" => "14:30", "end_time" => "16:30"],
        //     ["start_time" => "11:30", "end_time" => "13:00"],
        //     ["start_time" => "10:30", "end_time" => "11:30"],
        // ];

        // usort($periods, function ($a, $b) use ($start_time_key, $end_time_key) {
        //     return strtotime($start_time_key) <=> strtotime($end_time_key);
        // });


        // foreach ($periods as $key => $period) {
        //     if ($key != 0) {
        //         if (strtotime($start_time_key) < strtotime($periods[$key - 1][$end_time_key])) {
        //             return true;
        //         }
        //     }
        // }
        // return false;


    }

    public function getRoomByShowTime($showTimeId)
    {
        return $this->model->newQuery()
            ->with([
                'movie', 'room' => function ($query) {
                    $query->with([
                        'seats' => function ($query) {
                            $query->with('seat_type');
                        },
                        'cinema'
                    ]);
                }
            ])
            ->where('id', $showTimeId)
            ->firstOrFail();
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

    public function listShowTimeByCinema($data)
    {
        // có thể lấy ra tên phòng và số ghế trống nếu cần 
        return $this->model
            ->select("show_times.*")
            ->join("rooms", "rooms.id", "=", "show_times.room_id")
            ->where('show_times.movie_id', $data['movie_id'])
            ->where('rooms.cinema_id', $data['cinema_id'])
            ->where('time_start', '>=', now())
            ->whereRaw("time_start like '" . $data['current_date'] . "%'")
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
