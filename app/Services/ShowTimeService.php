<?php

namespace App\Services;

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

        $data = $request->validated();
        try {
            DB::beginTransaction();
            $show_time = $this->showTimeRepository->createShowTime($data);

            // $this->seatRepository->createSeat($data['seats'], $room->id);

            // $user->load('adminInfo');

            DB::commit();
            return $show_time;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function list($request)
    {
        // $admin = Auth::guard('admin')->user();
        // $arr_cinema_id = $this->cinemaRepository->getAllCinemaByAdmin($admin->id);
        $cinema_id = $request->cinema_id;
        $showtimes = $this->showTimeRepository->list($request, $cinema_id);
        return ViewShowTimeResource::collection($showtimes);
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
