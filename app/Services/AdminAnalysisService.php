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
        $labelWeek = $this->dataWeekAnalysis($request);

        return $this->adminAnalysisRepository->getMovieAnalysis($request, $cinemaId, $labelWeek);
    }

    private function getDataLabels($request)
    {
        $startDate = Carbon::parse($request->selected_month)->startOfMonth();
        $endDate = is_null($request->selected_month) ? Carbon::now() : Carbon::parse($request->selected_month)->endOfMonth();
        return $this->formatDate($startDate, $endDate);
    }


    private function dataWeekAnalysis($request)
    {
        if ($request->selected_month) {
            $startDate = Carbon::parse($request->selected_month)->endOfMonth()->subDays(6);
            $endDate = Carbon::parse($request->selected_month)->endOfMonth();
        } else {
            $startDate = Carbon::now()->subDays(6);
            $endDate = Carbon::now();
        }

        return $this->formatDate($startDate, $endDate);
    }

    private function formatDate($startDate, $endDate)
    {
        $arr = array();
        $period = CarbonPeriod::create($startDate, $endDate);

        foreach ($period as $day) {
            array_push($arr, $day->format('d-m-Y'));
        }

        return $arr;
    }
}
