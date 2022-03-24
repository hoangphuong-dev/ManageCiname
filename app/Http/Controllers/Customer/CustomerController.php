<?php

namespace App\Http\Controllers\Customer;

use App\Helper\FormatDate;
use App\Http\Controllers\Controller;
use App\Repositories\CinemaRepository;
use App\Repositories\ProvinceRepository;
use App\Services\MovieGenreService;
use App\Services\MovieService;
use App\Services\ShowTimeService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Inertia\Inertia;

class CustomerController extends Controller
{

    public $movieGenreService;
    public $movieSearvice;
    public $provinceRepository;
    public $cinemaRepository;
    public $showTimeService;

    public function __construct(
        MovieGenreService $movieGenreService,
        MovieService $movieService,
        ProvinceRepository $provinceRepository,
        CinemaRepository $cinemaRepository,
        ShowTimeService $showTimeService,
    ) {
        $this->movieGenreService = $movieGenreService;
        $this->movieSearvice = $movieService;
        $this->provinceRepository = $provinceRepository;
        $this->cinemaRepository = $cinemaRepository;
        $this->showTimeService = $showTimeService;
    }

    public function index(Request $request)
    {
        $movie_genres = $this->movieGenreService->list($request);
        return Inertia::render('Customer/Home', [
            'movie_genres' => $movie_genres
        ]);
    }

    public function detailMovie($id)
    {
        $movie = $this->movieSearvice->show($id);
        // todo : lay id the loai truyen vao day 
        $arr_movie_genre_id = ["1", "2"];
        $movie_relates = $this->movieSearvice->getMovieRelated($arr_movie_genre_id);
        return Inertia::render('Customer/MovieDetail', [
            'movie' => $movie,
            'movie_relates' => $movie_relates,
        ]);
    }

    public function getProvince()
    {
        return $this->provinceRepository->list();
    }

    public function getCinemaByProvince($id)
    {
        return $this->cinemaRepository->listCinemaByProvince($id);
    }

    public function showSeatByShowTime(Request $request)
    {
        // dd($request);
        // lay ra thong tin cua suat chieu hien tai (phong , so ghe trong, daban )
        $rooms = $this->showTimeService->getRoomByShowTime($request->current_showtime);
        dd($rooms);
    }

    public function orderTicket(Request $request)
    {
        $data = $request->all();
        $date = Carbon::now()->toDateString();
        if (!isset($data['current_date'])) {
            $data['current_date'] = $date;
        }
        // dd($data);
        $showtimes =  ($this->showTimeService->listShowTimeByCinema($data)->collection);


        $formatDate = new FormatDate();
        $twoWeeks = $formatDate->getTwoWeek();
        return Inertia::render('Customer/ViewShowTime', [
            'twoWeeks' => $twoWeeks,
            'filterFE' => $data,
            'showtimes' => $showtimes,
        ]);
    }

    public function getShowTimeByDay()
    {
        // $request = array();
        // $request['day'] = '2022-08-02';
        // $request['movie_id'] = '1';
        // $request['cinema_id'] = '1';

        // dd($showtimes);

        return Inertia::render('Customer/ViewShowTime', [
            // 'showtimes' => $showtimes,
        ]);
    }
}
