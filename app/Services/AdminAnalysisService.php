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
        $cinemaId = $this->getCinemaId();
        $label = $this->getDataLabels($request);

        return $this->adminAnalysisRepository->analysisByCinema($request, $label, $cinemaId);
    }

    public function getMovieAnalysis($request)
    {
        $cinemaId = $this->getCinemaId();
        return $this->adminAnalysisRepository->getMovieAnalysis($request, $cinemaId);
    }

    private function getDataLabels($request)
    {
        $arr = array();

        $startDate = Carbon::parse($request->selected_month)->startOfMonth();
        $endDate = is_null($request->selected_month) ? Carbon::now() : Carbon::parse($request->selected_month)->endOfMonth();

        $period = CarbonPeriod::create($startDate, $endDate);

        foreach ($period as $day) {
            array_push($arr, $day->format('d-m-Y'));
        }

        return $arr;
    }
}
