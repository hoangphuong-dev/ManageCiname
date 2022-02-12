<?php

namespace App\Repositories;

use App\Models\MovieGenre;

class MovieGenreRepository
{
    protected $movieGenre;

    public function __construct(MovieGenre $movieGenre)
    {
        $this->movieGenre = $movieGenre;
    }

    public function list($request)
    {
        return $this->movieGenre->query()
            ->when($request->name, function ($query) use ($request) {
                return $query->where("name", "like", "%{$request->name}%");
            })
            ->when($request->price, function ($query) use ($request) {
                return $query->where("price", $request->price);
            })
            ->paginate($request->query('limit', 10));
    }

    public function all()
    {
        return $this->movieGenre->query()->get();
    }

    public function store($fill)
    {
        return $this->movieGenre->create($fill);
    }
}
