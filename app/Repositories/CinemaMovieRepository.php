<?php

namespace App\Repositories;

use App\Models\CinemaMovie;
use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;
//use Your Model

/**
 * Class CinemaMovieRepository.
 */
class CinemaMovieRepository extends BaseRepository
{
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        return CinemaMovie::class;
    }

    public function make($data, $movie_id)
    {
        foreach ($data as $item) {
            $this->model->create([
                'movie_id' => $movie_id,
                'cinema_id' => $item['id'],

            ]);
        }
    }
}
