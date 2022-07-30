<?php

namespace App\Http\Controllers\Backs\Staff;

use App\Http\Controllers\Controller;
use App\Models\Movie;
use App\Services\MovieGenreService;
use App\Services\MovieService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class StaffController extends Controller
{
    private $movieService;
    private $movieGenreService;

    public function __construct(
        MovieService $movieService,
        MovieGenreService $movieGenreService
    ) {
        $this->movieService = $movieService;
        $this->movieGenreService = $movieGenreService;
    }

    public function index()
    {
        return Inertia::render('Backs/Staff/Index');
    }

    public function getMovieNowShowing(Request $request)
    {
        $request->merge(['display' => 1]);
        return $this->movie($request);
    }

    public function getMovieCommingSoon(Request $request)
    {
        $request->merge(['display' => 2]);
        return $this->movie($request);
    }

    public function movie(Request $request)
    {
        $movie_genres = $this->movieGenreService->all();
        $movies = $this->movieService->list($request);

        return Inertia::render('Backs/Staff/Movie', [
            'movieGenre' => $movie_genres,
            'movies' => $movies,
            'filtersBE' => $request->all(),
        ]);
    }

    public function detail($id)
    {
        $movie = $this->movieService->show($id);

        return Inertia::render('Backs/Staff/MovieDetail', [
            'movie' => $movie,
        ]);
    }

    public function order(Request $request, $movieId)
    {
        return Inertia::render('Backs/Staff/ShowTime');
    }
}
