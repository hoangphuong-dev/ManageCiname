<?php

namespace App\Services;

use App\Http\Requests\ShowTimeRequest;
use App\Http\Resources\CalenderResource;
use App\Http\Resources\ShowTimeResource;
use App\Http\Resources\ViewShowTimeResource;
use App\Models\Movie;
use App\Repositories\CinemaRepository;
use App\Repositories\ShowTimeRepository;
use Illuminate\Support\Facades\DB;

class ShowTimeService extends BaseService
{
    protected $showTimeRepository;
    protected $cinemaRepository;

    public function __construct(
        ShowTimeRepository $showTimeRepository,
        CinemaRepository $cinemaRepository
    ) {
        $this->showTimeRepository = $showTimeRepository;
        $this->cinemaRepository = $cinemaRepository;
    }

    public function getRoomByShowTime($showTimeId)
    {
        return $this->showTimeRepository->getRoomByShowTime($showTimeId);
    }

    public function checkShowTime($request)
    {
        $data = $this->convertTime($request->validated());
        return $this->showTimeRepository->checkShowTime($data);
    }

    public function convertTime($fill)
    {
        $fill['day'] = date_format(date_create($fill['day']), "Y-m-d");
        $fill['time_start'] = date_format(date_create($fill['time_start']), "H:i");
        $fill['time_end'] = date_format(date_create($fill['time_end']), "H:i");
        return $fill;
    }

    public function store($request)
    {
        $fill = $this->convertTime($request->validated());

        $data = [
            'room_id' => $fill['room_id'],
            'movie_id' => $fill['movie_id'],
            'time_start' => $fill["day"] . ' ' . $fill['time_start'],
            'time_end' =>  $fill["day"] . ' ' . $fill["time_end"],
        ];
        return $this->showTimeRepository->createShowTime($data);
    }

    public function listShowTimeByCinema($request)
    {
        $showtimes = $this->showTimeRepository->listShowTimeByCinema($request);
        return ShowTimeResource::collection($showtimes);
    }

    public function list($request)
    {
        $cinema_id = $request->cinema_id;
        $showtimes = $this->showTimeRepository->list($request, $cinema_id);
        return ViewShowTimeResource::collection($showtimes);
    }

    public function listShowTimeByRoom($roomId, $request)
    {
        $showtimes = $this->showTimeRepository->listShowTimeByRoom($roomId, $request);
        return CalenderResource::collection($showtimes);
    }

    public function  getShowTimeByMovieDay($cinema_id, $movie_id, $day)
    {
        return $this->showTimeRepository->getShowTimeByMovieDay($cinema_id, $movie_id, $day);
    }

    public function getMovieById($movie_id)
    {
        return Movie::where('id', $movie_id)->firstOrFail();
    }
}
