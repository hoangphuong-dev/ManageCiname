<?php

namespace App\Repositories;

use App\Models\StaffInfo;
use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;
//use Your Model

/**
 * Class StaffInfoRepository.
 */
class StaffInfoRepository extends BaseRepository
{
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        return StaffInfo::class;
    }
}
