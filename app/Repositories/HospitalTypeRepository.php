<?php

namespace App\Repositories;

use App\Models\HospitalType;
use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;

/**
 * Class HospitalTypeRepository.
 */
class HospitalTypeRepository extends BaseRepository
{
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        return HospitalType::class;
    }
}
