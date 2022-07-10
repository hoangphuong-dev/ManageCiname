<?php

namespace App\Repositories;

use App\Models\Bill;
use App\Models\Cinema;
use App\Models\Province;
use Carbon\Carbon;

/**
 * Class SuperAdminAnalysisRepository.
 */
class SuperAdminAnalysisRepository extends ProvinceRepository
{

    public function analysisByProvince($request)
    {
        $arrRevenuaProvince = [];
        $provinces = $this->getProvinceHasCinema();

        foreach ($provinces as $province) {
            $data = Province::query()
                ->with('cinemas')
                ->where('id', $province->id)->first();

            $arrCinemaId = $data->cinemas->pluck('id')->toArray();

            $revenuaProvince = $this->getRevenuaProvinceByMonth($arrCinemaId, $request->selected_month);

            array_push($arrRevenuaProvince, $revenuaProvince);
        }

        return [
            'revenua' => $arrRevenuaProvince,
            'provinces' => $provinces->pluck('name')->toArray(),
        ];
    }

    public function getRevenuaProvinceByMonth($arrCinemaId, $month)
    {
        $result = 0;

        $monthFormat = Carbon::parse($month)->format('Y-m');

        foreach ($arrCinemaId as $item) {
            $bills = Bill::query()
                ->where('created_at', 'LIKE', "{$monthFormat}%")
                ->where('cinema_id', $item)->get();
            $result += $bills->sum('total_money');
        }

        return $result;
    }
}
