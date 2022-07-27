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

    public function movie(Request $request)
    {
        $request->merge(['display' => 1]);

        // $request->display = 1;

        // dd($request->display);

        $movie_genres = $this->movieGenreService->all();
        $movies = $this->movieService->list($request);


        return Inertia::render('Backs/Staff/Movie', [
            'movieGenre' => $movie_genres,
            'movies' => $movies,
            'filtersBE' => $request->all(),
        ]);
    }
}
