<?php

namespace App\Repositories;

use App\Models\MovieGenre;
use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;

class MovieGenreRepository extends BaseRepository
{
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        return MovieGenre::class;
    }

    public function list($request)
    {
        return $this->model
            ->when($request->name, function ($query) use ($request) {
                return $query->where("name", "like", "%{$request->name}%");
            })
            ->when($request->price, function ($query) use ($request) {
                return $query->where("price", $request->price);
            })->get();
    }

    public function store($fill)
    {
        return $this->model->create($fill);
    }
}
