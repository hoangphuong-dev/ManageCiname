<?php

namespace App\Repositories;

use App\Models\Province;
use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;
//use Your Model

/**
 * Class ProvinceRepository.
 */
class ProvinceRepository extends BaseRepository
{
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        return Province::class;
    }

    public function list()
    {
        return $this->model->all()->toArray();
    }
}
