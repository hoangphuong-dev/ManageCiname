<?php

namespace App\Repositories;

use App\Helper\FormatDate;
use App\Models\Filters\MovieFilters;
use App\Models\Movie;
use App\Models\ShowTime;
use App\Models\Ticket;
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

    public function getMovieHot()
    {
        return $this->model->newQuery()
            ->select('id', 'trailer')
            ->whereIn(
                'id',
                ShowTime::select('movie_id')
                    ->whereIn(
                        'id',
                        Ticket::select('showtime_id')
                            ->selectRaw('count(showtime_id) as "number"')
                            ->groupBy('showtime_id')->orderBy('number', 'desc')->limit(10)->pluck('showtime_id')->toArray()
                    )->get()->toArray()


            )->get();
    }

    public function list($request)
    {
        return $this->model
            ->orderBy('id', "DESC")
            ->filters(new MovieFilters($request))
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
            'trailer' => $fill['trailer'],
            'movie_length' => $fill['movie_length'],
            'rated' => $fill['rated'],
            'status' => $fill['status'],
        ]);
    }

    public function show($id)
    {
        return $movie = $this->model
            ->with(['showtimes' => function ($query) {
                $query->orderBy('time_start')->first();
            }])
            ->findOrFail($id);
    }
}
