<?php

namespace App\Repositories;

use App\Models\Movie;
use Illuminate\Support\Facades\DB;
use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;
//use Your Model

/**
 * Class MovieRepository.
 */
class MovieRepository extends BaseRepository
{
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        return Movie::class;
    }

    public function list($request)
    {
        return $this->model->query()
            ->when($request->name, function ($query) use ($request) {
                return $query->where("name", "like", "%{$request->name}%");
            })
            ->orderBy('id', "DESC")
            ->paginate($request->query('limit', 10));
    }

    public function updateStatus($id, $request)
    {
        $status = $request->status;
        return $this->model->where('id', $id)->update(['status' => $status]);
    }

    // public function getMovieByCinema($id)
    // {
    //     return $this->model->query()
    //         ->with('cinemas')
    //         // ->select('movies.name', 'cinema_movies.*')
    //         // ->join('cinema_movies', 'cinema_movies.movie_id', '=', 'movies.id')
    //         // ->where('cinema_movies.cinema_id', $id)
    //         ->where('movies.status', Movie::MOVIE_ACTIVE)->get();
    // }

    public function createMovie($fill)
    {
        $fill['status'] = Movie::MOVIE_ACTIVE;
        return $this->model->create([
            'name' => $fill['name'],
            'director' => $fill['director'],
            'description' => $fill['description'],
            'trailler' => $fill['trailler'],
            'movie_length' => $fill['movie_length'],
            'rated' => $fill['rated'],
            'status' => $fill['status'],
        ]);
    }
}
