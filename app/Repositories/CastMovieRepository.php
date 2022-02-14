<?php

namespace App\Repositories;

use App\Models\CastMovie;
use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;
//use Your Model

/**
 * Class CastMovieRepository.
 */
class CastMovieRepository extends BaseRepository
{
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        return CastMovie::class;
    }

    public function make($data, $movie_id)
    {
        foreach ($data as $row) {
            $this->model->create([
                'cast_id' => $row,
                'movie_id' => $movie_id,
            ]);
        }
    }
}
