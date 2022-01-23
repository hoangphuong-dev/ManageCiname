<?php

namespace App\Services;

use App\Http\Resources\HospitalAnalyticResource;
use App\Http\Resources\JobBeLongToHospital;
use App\Repositories\HospitalRepository;
use App\Repositories\JobRepository;

class HospitalService extends BaseService
{
    private $hospitalRepository;
    private $jobRepository;

    public function __construct(HospitalRepository $hospitalRepository, JobRepository $jobRepository)
    {
        $this->hospitalRepository = $hospitalRepository;
        $this->jobRepository = $jobRepository;
    }

    public function analytics($request)
    {
        $analytics = $this->hospitalRepository->analytics($request);
        return HospitalAnalyticResource::collection($analytics);
    }

    public function listJobHospital($hospitalId, $request)
    {
        $jobs = $this->jobRepository->getJobBeLongToHospital($hospitalId, $request);
        return JobBeLongToHospital::collection($jobs);
    }
}
