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

    public function createMovie($data)
    {
        $data['status'] = Movie::MOVIE_ACTIVE;
        DB::beginTransaction();

        try {
            $job = Movie::create($data);


            DB::commit();
            return true;
        } catch (\Throwable $e) {
            DB::rollback();
            throw ($e);
        }
    }
}
