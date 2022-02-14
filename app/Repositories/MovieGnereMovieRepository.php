<?php

namespace App\Repositories;

use App\Models\MovieGenreMovie;
use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;
//use Your Model

/**
 * Class MovieGnereMovieRepository.
 */
class MovieGnereMovieRepository extends BaseRepository
{
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        return MovieGenreMovie::class;
    }

    public function make($data, $movie_id)
    {
        foreach ($data as $row) {
            $this->model->create([
                'movie_genre_id' => $row,
                'movie_id' => $movie_id,
            ]);
        }
    }
}
