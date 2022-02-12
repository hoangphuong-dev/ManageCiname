<?php

namespace App\Services;

use App\Http\Resources\MovieResource;
use App\Repositories\AdminInfoRepository;
use App\Repositories\CastMovieRepository;
use App\Repositories\CinemaMovieRepository;
use App\Repositories\CinemaRepository;
use App\Repositories\MovieGnereMovieRepository;
use App\Repositories\MovieRepository;
use Illuminate\Support\Facades\DB;

class MovieService extends BaseService
{
    protected $movieRepository;
    protected $adminInfoRepository;
    protected $movieGnereMovieRepository;
    protected $castMovieRepository;
    protected $cinemaRepository;
    protected $cinemaMovieRepository;

    public function __construct(
        MovieRepository $movieRepository,
        AdminInfoRepository $adminInfoRepository,
        MovieGnereMovieRepository $movieGnereMovieRepository,
        CastMovieRepository $castMovieRepository,
        CinemaRepository $cinemaRepository,
        CinemaMovieRepository $cinemaMovieRepository,
    ) {
        $this->movieRepository = $movieRepository;
        $this->adminInfoRepository = $adminInfoRepository;
        $this->movieGnereMovieRepository = $movieGnereMovieRepository;
        $this->castMovieRepository = $castMovieRepository;
        $this->cinemaRepository = $cinemaRepository;
        $this->cinemaMovieRepository = $cinemaMovieRepository;
    }

    public function getProvinceShowMovie()
    {
        return $this->adminInfoRepository->getProvinceShowMovie();
    }


    public function list($request)
    {
        $movie = $this->movieRepository->list($request);
        return MovieResource::collection($movie);
    }

    public function store($fill)
    {
        $province = $fill['province'];
        $id_cinema = $this->getCinemesByProvince($province);

        $movie_genre = $fill['movie_genre'];
        $cast = $fill['movie_genre'];
        // try {
        // DB::beginTransaction();
        $movie = $this->movieRepository->createMovie($fill);
        $this->movieGnereMovieRepository->make($movie_genre, $movie->id);
        $this->castMovieRepository->make($cast, $movie->id);
        if (count($id_cinema) > 0) {
            $this->cinemaMovieRepository->make($id_cinema, $movie->id);
        }
        // $this->DB::commit();
        // } catch (\Exception $e) {
        // DB::rollback();
        // throw $e;
        // }
    }

    public function getCinemesByProvince($arrayProvinve)
    {
        $arrayAdminInfo = $this->adminInfoRepository->getArrayIdAdminInfo($arrayProvinve);
        return $this->cinemaRepository->getArrayIdCinemaByAdminInfo($arrayAdminInfo);
    }
}
