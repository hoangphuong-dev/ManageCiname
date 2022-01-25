<?php

namespace App\Services;

use App\Http\Resources\MovieGenreResource;
use App\Http\Resources\MovieResource;
use App\Repositories\MovieGenreRepository;
use App\Repositories\MovieRepository;

class MovieService extends BaseService
{
    protected $movieRepository;

    public function __construct(MovieRepository $movieRepository)
    {
        $this->movieRepository = $movieRepository;
    }

    public function list($request)
    {
        $movie = $this->movieRepository->list($request);
        return MovieResource::collection($movie);
    }
}
