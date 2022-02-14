<?php

namespace App\Services;

use App\Http\Resources\ContactResource;
use App\Repositories\MasterDataRepository;

class MasterDataService extends BaseService
{
    protected $masterDataRepository;

    public function __construct(MasterDataRepository $masterDataRepository)
    {
        $this->masterDataRepository = $masterDataRepository;
    }

    public function listHospitalType()
    {
        return $this->masterDataRepository->listHospitalType();
    }
}
