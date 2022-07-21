<?php

namespace App\Repositories;

use App\Models\ShowTime;
use App\Models\ViewShowTimeByDay;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
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

    public function getDataTicketByMonth($request)
    {
        return $this->model->newQuery()
            ->select('show_times.movie_id', 'movies.name')
            ->selectRaw('count(*) as ticket_ordered')
            ->when($request->date_from_ticket && $request->date_to_ticket, function ($query) use ($request) {
                return $query->whereBetween('tickets.created_at', [$request->date_from_ticket, $request->date_to_ticket]);
            })
            ->join('tickets', 'tickets.show_time_id', '=', 'show_times.id')
            ->join('movies', 'movies.id', '=', 'show_times.movie_id')
            ->groupBy('movie_id', 'name')
            ->get()->toArray();
    }

    public function checkShowTime($data)
    {
        $time_start = strtotime($data['day'] . ' ' . $data['time_start']);
        $now = strtotime(now());
        if ($time_start <= $now) return true;

        // lay ra tat ca suat chieu cua ngay duoc truyen vao 
        $showtimes = $this->model->newQuery()
            ->selectRaw('DATE_FORMAT(time_start, "%H:%i") as time_start, DATE_FORMAT(time_end, "%H:%i") as time_end')
            ->where('room_id', $data['room_id'])
            ->whereRaw('DATE_FORMAT(time_start, "%Y-%m-%d") like "' . $data['day'] . '"')
            ->orderBy('time_start')
            ->get()->toArray();

        foreach ($showtimes as $showtime) {
            // kiem tra suat chieu trong suat chieu da co 
            if (strtotime($showtime['time_start']) < strtotime($data['time_start']) && strtotime($data['time_start']) < strtotime($showtime['time_end'])) {
                return true;
            }
            if (strtotime($showtime['time_start']) < strtotime($data['time_end']) && strtotime($data['time_end']) < strtotime($showtime['time_end'])) {
                return true;
            }
            // kiem tra suat chieu da co trong suat chieu truyen vao 
            if (strtotime($data['time_start']) < strtotime($showtime['time_start']) && strtotime($showtime['time_start']) < strtotime($data['time_end'])) {
                return true;
            }
            if (strtotime($data['time_start']) < strtotime($showtime['time_end']) && strtotime($showtime['time_end']) < strtotime($data['time_end'])) {
                return true;
            }
        }
        return false;
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
            'room_id' => $data['room_id'],
            'time_start' => $data['time_start'],
            'time_end' => $data['time_end'],
        ]);
    }

    public function listShowTimeByCinema($data)
    {
        return $this->model
            ->whereHas('room', function (Builder $query) use ($data) {
                $query->where('rooms.cinema_id', $data['cinema_id']);
            })
            ->with(['room' => function ($query) {
                $query->withCount('seats');
            }])
            ->withCount('tickets')
            // ->whereRaw("UNIX_TIMESTAMP(time_start) >= " . Carbon::now()->timestamp)
            ->where("time_start", '>=', now())
            ->where('show_times.movie_id', $data['movie_id'])
            ->whereRaw("time_start like '" . $data['current_date'] . "%'")
            ->get();
    }

    // public function list($request, $cinema_id)
    // {
    //     return ViewShowTimeByDay::query()
    //         ->when($request->name, function ($query) use ($request) {
    //             return $query->where("name", "like", "%{$request->name}%");
    //         })
    //         ->where('cinema_id', $cinema_id)
    //         ->orderBy('day')
    //         ->paginate($request->query('limit', 12));
    // }

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
