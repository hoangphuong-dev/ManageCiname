<?php

namespace App\Services;

use App\Http\Resources\MovieGenreResource;
use App\Repositories\MovieGenreRepository;

class MovieGenreService extends BaseService
{
    protected $movieGenreRepository;

    public function __construct(MovieGenreRepository $movieGenreRepository)
    {
        $this->movieGenreRepository = $movieGenreRepository;
    }

    public function list($request)
    {
        $movieGenre = $this->movieGenreRepository->list($request);
        return MovieGenreResource::collection($movieGenre);
    }


}
