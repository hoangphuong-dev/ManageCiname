<?php

namespace App\Repositories;

use App\Models\HospitalType;

class MasterDataRepository
{
    protected $hospitalType;

    public function __construct(HospitalType $hospitalType)
    {
        $this->hospitalType = $hospitalType;
    }

    public function listHospitalType()
    {
        $hospitalTypes = $this->hospitalType->query()
            ->select('id', 'name')
            ->get();

        return $hospitalTypes;
    }
}
