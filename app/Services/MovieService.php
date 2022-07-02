<?php

namespace App\Services;

use App\Http\Resources\MovieResource;
use App\Models\MovieFormatMovie;
use App\Repositories\CastMovieRepository;
use App\Repositories\CinemaMovieRepository;
use App\Repositories\CinemaRepository;
use App\Repositories\MovieGnereMovieRepository;
use App\Repositories\MovieRepository;
use Illuminate\Support\Facades\DB;

class MovieService extends BaseService
{
    protected $movieRepository;
    protected $movieGnereMovieRepository;
    protected $castMovieRepository;
    protected $cinemaRepository;
    protected $cinemaMovieRepository;
    protected $movieGenreService;

    public function __construct(
        MovieRepository $movieRepository,
        MovieGenreService $movieGenreService,
        MovieGnereMovieRepository $movieGnereMovieRepository,
        CastMovieRepository $castMovieRepository,
        CinemaRepository $cinemaRepository,
        CinemaMovieRepository $cinemaMovieRepository,
    ) {
        $this->movieRepository = $movieRepository;
        $this->movieGenreService = $movieGenreService;
        $this->movieGnereMovieRepository = $movieGnereMovieRepository;
        $this->castMovieRepository = $castMovieRepository;
        $this->cinemaRepository = $cinemaRepository;
        $this->cinemaMovieRepository = $cinemaMovieRepository;
    }

    public function getMovieNowShowing($request)
    {
        $movies = $this->movieRepository->getMovieNowShowing($request);

        return MovieResource::collection($movies);
    }

    public function getMovieCommingSoon($request)
    {
        $movies = $this->movieRepository->getMovieCommingSoon($request);

        return MovieResource::collection($movies);
    }

    public function getMovieHot()
    {
        return $this->movieRepository->getMovieHot();
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

    public function getListMovieGenre()
    {
        return $this->movieGenreService->all();
    }

    public function show($id)
    {
        $movie = $this->movieRepository->show($id);
        return $movie;
    }

    public function getMovieRelated($arr_movie_genre_id)
    {
        $movies = $this->movieRepository->getMovieRelated($arr_movie_genre_id);
        return MovieResource::collection($movies);
    }

    public function  updateStatus($id, $request)
    {
        return $this->movieRepository->updateStatus($id, $request);
    }

    public function store($fill)
    {
        $id_cinema = $this->getAllCinemes();
        $movie_genre = $fill['movie_genre'];
        $cast = $fill['movie_genre'];
        try {
            DB::beginTransaction();
            $movie = $this->movieRepository->createMovie($fill);
            $this->movieGnereMovieRepository->make($movie_genre, $movie->id);
            $this->castMovieRepository->make($cast, $movie->id);

            if (count($id_cinema) > 0) {
                $this->cinemaMovieRepository->make($id_cinema, $movie->id);
            }

            foreach ($fill['format'] as $item) {
                MovieFormatMovie::create([
                    'format_movie_id' => $item,
                    'movie_id' => $movie->id,
                ]);
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function edit($id)
    {
        $movie = $this->movieRepository->show($id);
        return MovieResource::make($movie);
    }

    public function delete($id)
    {
        return $this->movieRepository->deleteById($id);
    }

    public function getAllCinemes()
    {
        return $this->cinemaRepository->getAllArrayIdCinema();
    }
}
