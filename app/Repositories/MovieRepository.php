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
            // ->with(['movie_genres', 'casts', 'cinemas'])
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
        return $this->model->findOrFail($id);
    }

    public function destroy($id)
    {
        return $this->model->where('id', $id)->where('status', Movie::MOVIE_DEACTIVE)->delete();
    }
}
