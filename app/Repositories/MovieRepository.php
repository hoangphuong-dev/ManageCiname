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
            ->select("movies.*")
            // ->with(['movie_genres', 'casts', 'cinemas'])
            ->when($request->name, function ($query) use ($request) {
                return $query->where("name", "like", "%{$request->name}%");
            })
            ->when($request->action, function ($query) use ($request) {
                return $query->where("movies.status", "=", $request->action);
            })
            ->when($request->movie_genre, function ($query) use ($request) {
                return $query
                    ->join("movie_genre_movies", "movie_genre_movies.movie_id", "=", "movies.id")
                    ->where("movie_genre_id", "=", $request->movie_genre);
            })
            ->orderBy('id', "DESC")
            ->paginate($request->query('limit', 12));
    }

    public function updateStatus($id, $request)
    {
        $status = $request->status;
        return $this->model->where('id', $id)->update(['status' => $status]);
    }

    public function getMovieRelated($arr_movie_genre_id)
    {
        return $this->model
            ->select("movies.*")
            ->join("movie_genre_movies", "movie_genre_movies.movie_id", "=", "movies.id")
            ->whereIn("movie_genre_id", $arr_movie_genre_id)
            ->where("movies.status", "=", Movie::MOVIE_ACTIVE)
            ->orderBy('created_at', "DESC")->limit(5)
            ->get();
    }


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

    public function show($id)
    {
        // $callable = function (&$query) use ($userId) {
        //     $query->where('user_id', $userId);
        // };
        // return $this->job->query()
        //     ->with(['province', 'images', 'tags'])
        //     ->when($userId, function ($query) use ($callable) {
        //         $query->with(['jobApplyPending' => $callable, 'jobApplyReject' => $callable, 'favorites' => $callable]);
        //     })
        //     ->findOrFail($id);
        return $this->model
            ->with(['movie_genres', 'casts'])
            ->findOrFail($id);
    }

    public function destroy($id)
    {
        return $this->model->where('id', $id)->where('status', Movie::MOVIE_DEACTIVE)->delete();
    }
}
