<?php

namespace App\Repositories;

use App\Models\HospitalInfo;
use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;
//use Your Model

/**
 * Class HospitalInfoRepository.
 */
class HospitalInfoRepository extends BaseRepository
{
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        return HospitalInfo::class;
    }

    /**
     * create user hospital info
     * @param
     * array fill constant hospitalType, images as array, content, address, phone
     * @return boolean
     *  Return the HospitalInfo model
     */
    public function make($fill, $user_id) {
        return $this->create([
            'user_id' => $user_id,
            'hospital_type_id' => $fill['hospitalType'],
            'image' => json_encode($fill['images']),
            'content' => $fill['content'],
            'address' => $fill['address'],
            'phone' => $fill['phone']
        ]);
    }
}
