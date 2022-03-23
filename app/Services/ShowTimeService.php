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

    public function store($request)
    {
        $fill = $request->validated();
        $data = [
            'romm_id' => $fill['romm_id'],
            'movie_id' => $fill['movie_id'],
            'time_start' => $fill['day'] . ' ' . $fill['time_start'],
            'time_end' =>  $fill['day'] . ' ' . $fill['time_end'],
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
        // $admin = Auth::guard('admin')->user();
        // $arr_cinema_id = $this->cinemaRepository->getAllCinemaByAdmin($admin->id);
        $cinema_id = $request->cinema_id;
        $showtimes = $this->showTimeRepository->list($request, $cinema_id);
        return ViewShowTimeResource::collection($showtimes);
    }

    public function listShowTimeByRoom($roomId, $request)
    {
        $showtimes = $this->showTimeRepository->listShowTimeByRoom($roomId, $request);
        return CalenderResource::collection($showtimes);

        // return ViewShowTimeResource::collection($showtimes);
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
