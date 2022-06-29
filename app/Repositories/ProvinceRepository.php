<?php

namespace App\Repositories;

use App\Models\Cinema;
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

    public function getProvinceHasCinema()
    {
        $province_id = Cinema::get()->pluck('province_id')->toArray();

        return $this->model->whereIn('id', $province_id)->get();
    }
}
