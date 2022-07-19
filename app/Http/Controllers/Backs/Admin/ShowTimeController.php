<?php

namespace App\Http\Controllers\Backs\Admin;

use App\Exceptions\CustomerException;
use App\Http\Controllers\Controller;
use App\Http\Requests\ShowTimeRequest;
use App\Services\CinemaService;
use App\Services\ShowTimeService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ShowTimeController extends Controller
{
    protected $showTimeService;
    protected $cinemaService;

    public function __construct(
        ShowTimeService $showTimeService,
        CinemaService $cinemaService
    ) {
        $this->showTimeService = $showTimeService;
        $this->cinemaService = $cinemaService;
    }

    public function index()
    {
        return Inertia::render('Backs/Admin/ShowTime');
    }

    public function store(ShowTimeRequest $request)
    {
        try {
            $check = $this->showTimeService->checkShowTime($request);

            if ($check) {
                throw new CustomerException($message = ['error' => __('Thời gian chiếu phim không không hợp lệ !')]);
            }

            $this->showTimeService->store($request);

            $message = ['success' => __('Tạo suất chiếu thành công !')];
        } catch (CustomerException $e) {
            $message = ['error' => __('Có lỗi trong quá trình thực thi !')];
        } catch (\Exception $e) {
            $message = ['error' => __('Có lỗi trong quá trình thực thi !')];
        } finally {
            return back()->with($message);
        }
    }

    public function viewDetailShowTimes($cinema_id, $movie_id, $day)
    {
        $cinema = $this->cinemaService->getMovieByCinema($cinema_id);
        $movie = $this->showTimeService->getMovieById($movie_id);

        $showtimes = $this->showTimeService->getShowTimeByMovieDay($cinema_id, $movie_id, $day);
        return Inertia::render('Backs/Admin/ShowTimeDetail', [
            'cinema' => $cinema,
            'showtimes' => $showtimes,
            'movie' => $movie,
            'day' => $day,
        ]);
    }

    public function viewDetailShowTimeById($cinema_id, $show_time_id)
    {
        $cinema = $this->cinemaService->getMovieByCinema($cinema_id);
        return Inertia::render('Backs/Admin/ShowTimeDetailById', [
            'cinema' => $cinema,
        ]);
    }
}
