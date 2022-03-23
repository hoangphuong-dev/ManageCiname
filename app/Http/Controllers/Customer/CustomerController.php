<?php

namespace App\Http\Controllers\Customer;

use App\Helper\FormatDate;
use App\Http\Controllers\Controller;
use App\Repositories\CinemaRepository;
use App\Repositories\ProvinceRepository;
use App\Services\MovieGenreService;
use App\Services\MovieService;
use App\Services\ShowTimeService;
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

    public function orderTicket(Request $request)
    {
        $this->getShowTimeByDay();
        // $showtimes =  $this->showTimeService->listShowTimeByCinema($request);
        // $formatDate = new FormatDate();
        // $twoWeeks = $formatDate->getTwoWeek();
        // dd($showtimes);
        // return Inertia::render('Customer/Home', []);
    }

    public function getShowTimeByDay()
    {
        $request = array();
        $request['day'] = '2022-08-02';
        $request['movie_id'] = '1';
        $request['cinema_id'] = '1';

        $showtimes = $this->showTimeService->listShowTimeByCinema($request);
        dd($showtimes);
    }
}
