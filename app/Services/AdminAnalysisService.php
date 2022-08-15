<?php

namespace App\Services;

use App\Repositories\AdminAnalysisRepository;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

/**
 * Class AdminAnalysisService
 * @package App\Services
 */
class AdminAnalysisService extends BaseService
{
    public $adminAnalysisRepository;

    public function __construct(AdminAnalysisRepository $adminAnalysisRepository)
    {
        $this->adminAnalysisRepository = $adminAnalysisRepository;
    }

    public function getDataAnalysis($request)
    {
        $adminId = $this->getUserId('admin');
        $label = $this->getDataLabels($request);

        return $this->adminAnalysisRepository->analysisByCinema($request, $label, $adminId);
    }

    private function getDataLabels($request)
    {
        $arr = array();

        $startDate = Carbon::parse($request->month)->startOfMonth();
        $endDate = is_null($request->month) ? Carbon::now() : Carbon::parse($request->month)->endOfMonth();

        $period = CarbonPeriod::create($startDate, $endDate);

        foreach ($period as $day) {
            array_push($arr, $day->format('d-m-Y'));
        }

        return $arr;
    }
}
