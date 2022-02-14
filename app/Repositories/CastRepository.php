<?php

namespace App\Repositories;

use App\Models\Cast;
use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;
//use Your Model

/**
 * Class CastRepository.
 */
class CastRepository extends BaseRepository
{
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        return Cast::class;
    }

    public function make($request)
    {
        $fill['name'] = $request['name'];
        return $this->model->create($fill);
    }

    public function list()
    {
        return $this->model->query()
            ->get();
    }
}
