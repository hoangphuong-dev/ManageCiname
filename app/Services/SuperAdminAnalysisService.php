<?php

namespace App\Services;

use App\Repositories\SuperAdminAnalysisRepository;

/**
 * Class SuperAdminAnalysisService
 * @package App\Services
 */
class SuperAdminAnalysisService
{
    protected $analysisRepository;

    public function __construct(SuperAdminAnalysisRepository $analysisRepository)
    {
        $this->analysisRepository = $analysisRepository;
    }

    public function getDataAnalysis($request)
    {
        return $this->analysisRepository->analysisByProvince($request);
    }

    public function getDataAnalysisDetail($request)
    {
        if (is_null($request->province)) {
            $request->province = $this->getListProvince()->first()->id;
        }

        return $this->analysisRepository->analysisByProvinceDetail($request);
    }

    public function getListProvince()
    {
        return $this->analysisRepository->getListProvince();
    }
}
