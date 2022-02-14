<?php

namespace App\Services;

use App\Repositories\HospitalTypeRepository;

class HospitalTypeService {

    private $hospitalTypeRepository;

    public function __construct(HospitalTypeRepository $hospitalTypeRepository)
    {
        $this->hospitalTypeRepository = $hospitalTypeRepository;
    }


    public function all() {
        return $this->hospitalTypeRepository->all();
    }
}
