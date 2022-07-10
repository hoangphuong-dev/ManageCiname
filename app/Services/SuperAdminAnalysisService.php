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
        // if ($request->type == "by-province") {
        $data = $this->analysisByProvince($request);
        // } else {
        // $data = [];
        // }

        return $data;
    }

    public function analysisByProvince($request)
    {
        return $this->analysisRepository->analysisByProvince($request);
    }
}
